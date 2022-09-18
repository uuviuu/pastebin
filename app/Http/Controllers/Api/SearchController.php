<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Filters\BooksFilter;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\BookResource;

class SearchController extends BaseController
{
    public function search(FilterRequest $request)
    {
        $data = $request->validated();
        $query = Book::query();
        if(isset($data['title'])){
            $query->where('title', 'LIKE', "%{$data['title']}%");
        }
        if(isset($data['author'])){
            $query->where('author', 'LIKE', "%{$data['author']}%");
        }
        $book = $query->paginate(5);;
        return BookResource::collection($book);
    }
    public function filter(FilterRequest $request)
    {
        $data = $request->validated();
        $query = Book::query();
        if(isset($data['title'])){
            $query->where('title', 'LIKE', $data['title']);
        }
        if(isset($data['author'])){
            $query->where('author', 'LIKE', $data['author']);
        }
        $book = $query->paginate(5);;
        return BookResource::collection($book);
    }
}
