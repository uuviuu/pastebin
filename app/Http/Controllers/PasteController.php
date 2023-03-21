<?php

namespace App\Http\Controllers;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use App\Http\Requests\CreatePasteRequest;
use App\Models\Paste;
use App\Service\PasteService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PasteController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function pastes()
    {
        $access = Access::getValues();

        if (!Auth::user()) {
            $access = array_diff($access, [Access::PRIVATE]);
        }

        return view('pastes', [
            'langs' => ['PHP','C','C++','C#','Python','JS'],
            'access' => $access,
            'expirationTime' => ExpirationTime::getValues(),
            'lastPastes' => PasteService::lastPastes(),
        ]);
    }

    /**
     * @param Paste $paste
     * @return Application|Factory|View
     */
    public function detail(Paste $paste)
    {
        PasteService::checkDetail($paste, Auth::user()['id'] ?? null);
        $paste->paste = br2nl($paste->paste);

        return view('paste_detail', [
            'paste' => $paste,
        ]);
    }

    /**
     * @param CreatePasteRequest $request
     * @return RedirectResponse
     */
    public function create(CreatePasteRequest $request): RedirectResponse
    {
        $data = PasteService::createData($request, Auth::user()['id'] ?? null);

        $expirationTime = $request->input('expirationTime') == ExpirationTime::INFINITELY ? null : $request->input('expirationTime');

        $paste = PasteService::create($data, $expirationTime);

        if (!$paste) {
            return redirect('', 500);
        }

        return redirect()->route('pastes.detail', $paste->paste_hash);
    }
}
