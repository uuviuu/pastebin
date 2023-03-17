<?php

namespace App\Http\Requests;

class PaginatePasteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => "string|nullable",
            "author" => "string|nullable",
            'search' => 'string|min:1|max:255',
            'page' => 'integer|min:1',
            'pageCapacity' => 'required|in:5,10,15',
        ];
    }
}