<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class EmployeeRequest extends FormRequest
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
        $rules = [
            'name' => ['required', "string","uppercase"],
            "email" => ["required", "email", Rule::unique("employees", "email")->ignore($this->route("employee"))],
            "job_id" => ["required", "exists:employee_jobs,id"],
            "age" => ["required", "numeric", "min:18", "max:60"],
            "hire_date" => ["required", "date"],
            "salary"    => ["required","min:1000","max:4000"],
        ];

        // if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
        //     $rules['name'] = ['required', 'unique:songs,name,' . $this->route('channel')->id];
        // }

        return $rules;
    }
}
