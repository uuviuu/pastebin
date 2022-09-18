<?php

namespace App\Service;

use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;

class BookService
{
    public function store($data)
    {
        try {
            DB::beginTransaction();
            
            Book::firstOrCreate($data);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    public function update($data, $item)
    {
        try {
            DB::beginTransaction();

            $item->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
        return $item;
    }
}
