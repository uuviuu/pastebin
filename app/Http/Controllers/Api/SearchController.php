<?php

namespace App\Http\Controllers\Api;

use App\Models\Paste;
use App\Http\Requests\PaginatePasteRequest;
use App\Http\Resources\PasteResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchController extends BaseController
{
//    public function search(PaginatePasteRequest $request): AnonymousResourceCollection
//    {
//        $query = Paste::query();
//        if($request->has('title')){
//            $query->where('title', 'LIKE', "%{$request->input('title')}%");
//        }
//        if($request->has('author')){
//            $query->where('author', 'LIKE', "%{$request->input('author')}%");
//        }
//        $paste = $query->paginate($request->input('pageCapacity', 5));
//
//        return PasteResource::collection($paste);
//    }
//    public function filter(PaginatePasteRequest $request): AnonymousResourceCollection
//    {
//        $data = $request->validated();
//        $query = Paste::query();
//        if(isset($data['title'])){
//            $query->where('title', 'LIKE', $data['title']);
//        }
//        if(isset($data['author'])){
//            $query->where('author', 'LIKE', $data['author']);
//        }
//        $paste = $query->paginate(5);
//
//        return PasteResource::collection($paste);
//    }
}
