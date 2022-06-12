<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Response;
use App\Http\Requests\BookRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\BookResource;

class BookController extends BaseController
{
    public function index()
    {
        $books = Book::paginate(5);
        return BookResource::collection($books);
    }
    
    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $this->service->store($data);
        return $data;
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(BookRequest $request, Book $book)
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
