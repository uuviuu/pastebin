<?php

namespace App\Http\Requests;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use Illuminate\Foundation\Http\FormRequest;

class CreatePasteRequest extends FormRequest
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
            'api_token' => 'string|max:80',
            'paste' => 'required|string',
            'lang' => 'required|string|in:PHP,C,C++,C#,Python,JS',
            'access' => 'required|string|in:'
                . implode(',', Access::getValues()),
            'expirationTime' => 'string|in:'
                . implode(',', ExpirationTime::getValues()),
        ];
    }
}
