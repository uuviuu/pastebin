<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Response;
use App\Http\Resources\BookResource;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends BaseController
{
    public function index()
    {
        return BookResource::collection(Book::all());
    }
    
    public function store(BookStoreRequest $request)
    {
        $data = $request->validated();
        $this->service->store($data);
        return $data;
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $data = $request->validated();
        $this->service->update($data, $book);
        return $data;
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
