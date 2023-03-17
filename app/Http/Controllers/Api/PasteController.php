<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PaginatePasteRequest;
use App\Models\Paste;
use Illuminate\Http\Response;
use App\Http\Requests\CreatePasteRequest;
use App\Http\Resources\PasteResource;

class PasteController extends BaseController
{
//    public function index(PaginatePasteRequest $request)
//    {
//        $pastes = Paste::paginate($request->input('pageCapacity', 5));
//
//        return PasteResource::collection($pastes);
//    }
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
