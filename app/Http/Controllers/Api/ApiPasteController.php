<?php

namespace App\Http\Controllers\Api;

use App\Enums\ExpirationTime;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Api\PaginatePasteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePasteRequest;
use App\Models\Paste;
use App\Service\PasteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApiPasteController extends Controller
{
    /**
     * @throws ValidationException
     * @throws UserNotFoundException
     */
    public function paginate(PaginatePasteRequest $request)
    {
        if (!Auth::user()) {
            throw new UserNotFoundException();
        }

        $pastes = Auth::user()
            ->pastes()
            ->where(function ($query) {
                $query->whereNull('expiration_time')
                    ->orWhere('expiration_time', '>=', Carbon::now());
            })
            ->orderBy('id', 'desc')
            ->defaultSort('created_at', 'desc')
            ->paginate($request->input('pageCapacity', 10));

        return apiResponse()->success($pastes);
    }

    public function detail(Paste $paste)
    {
        PasteService::checkDetail($paste, Auth::user()['id'] ?? null);

        return apiResponse()->success($paste);
    }

    public function create(CreatePasteRequest $request)
    {
        $data = [
            'created_by_id' => Auth::user()['id'] ?? null,
            'paste' => $request->input('paste'),
            'locale_lang' => $request->input('locale'),
            'paste_hash' => Str::random(),
            'access' => $request->input('access'),
        ];

        $expirationTime = $request->input('expirationTime') == ExpirationTime::INFINITELY ? null : $request->input('expirationTime');

        $paste = PasteService::create($data, $expirationTime);

        return apiResponse()->success($paste);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function complaint(Request $request)
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'pasteHash' => 'required|string|max:16',
            'complaint' => 'required|string|max:255',
        ]);
        $paste = PasteService::complaint($request->get('pasteHash'), $request->get('complaint'));

        return apiResponse()->success($paste);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws UserNotFoundException
     * @throws ValidationException
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'api_token' => 'required|string|max:80',
            'pasteHash' => 'required|string|max:16',
        ]);

        if (!Auth::user()->isAdmin()) {
            throw new UserNotFoundException();
        }

        Paste::findOrFail($request->get('pasteHash'))->delete();

        return apiResponse()->success();
    }
}
