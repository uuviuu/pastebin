<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\Api\PaginatePasteRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10);

        return apiResponse()->success($pastes);
    }
//
//    public function store(CreatePasteRequest $request)
//    {
//        $data = $request->validated();
//        $this->service->create($data);
//
//        return apiResponse()->success($files);
//    }
//
//    public function show(Paste $paste)
//    {
//        return new PasteResource($paste);
//    }
//
//    public function update(CreatePasteRequest $request, Paste $paste)
//    {
//        $data = $request->validated();
//        $this->service->update($data, $paste);
//
//        return $data;
//    }
//
//    public function destroy(Paste $paste)
//    {
//        $paste->delete();
//        return response(null, Response::HTTP_NO_CONTENT);
//    }
}
