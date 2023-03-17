<?php

namespace App\Http\Requests;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use Illuminate\Foundation\Http\FormRequest;

class CreatePasteRequest extends Request
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
            'paste' => 'required|string|max:255',
            'access' => 'required|string|in:'
                . implode(',', Access::getValues()),
            'locale' => 'required|string|max:10',
            'expirationTime' => 'string|in:'
                . implode(',', ExpirationTime::getValues()),
        ];
    }
}
