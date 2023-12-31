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
            'name'       => ['required', "string"],
            "email"      => ["required", "email", Rule::unique("employees", "email")->ignore($this->route("employee"))],
            "age"        => ["required", "numeric", "min:18", "max:60"],
            "job_id"     => ["required", "exists:employee_jobs,id"],
            "manager_id" => ["sometimes", "exists:employees,id"],
            "gender"     => ["required", "in:0,1,2"],
            "hire_date"  => ["required", "date"],
            "salary"     => ["required"],
        ];

        return $rules;
    }
}
