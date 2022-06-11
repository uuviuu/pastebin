<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|max:150",
            "author" => "required|max:100",
            "year_of_publication" => "nullable",
            "ISBN" => "required|unique:books,ISBN",
            "description" => "required|max:2000",
        ];
    }
}
