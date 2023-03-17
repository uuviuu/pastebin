<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
    protected $dontFlash = ['password', 'password_confirmation'];

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->response(
            $validator->getMessageBag()->toArray()
        ));
    }

    protected function formatErrors(Validator $validator): array
    {
        return $validator->errors()->all();
    }

    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
