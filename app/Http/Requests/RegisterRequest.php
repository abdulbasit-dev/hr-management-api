<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "result" => false,
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "message" => "The given data was invalid.",
            "errors" => $validator->errors()->all()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
