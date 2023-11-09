<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class EmployeeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'result'  => true,
            'message' => "Employee details.",
            'status'  => Response::HTTP_OK,
            'data' => [
                'id'           => $this->id,
                'name'         => $this->name,
                "email"        => $this->email,
                "job_title"    => $this->job->name ?? null,
                "manager_name" => $this->manager->name ?? null,
                "age"          => $this->age,
                "gender"       => $this->gender->getLabelText(),
                "hire_date"    => Carbon::parse($this->hire_date)->format('Y-m-d'),
                "salary"       => $this->salary,
                "create_at"    => $this->created_at->format('Y-m-d H:i:s'),
                "created_by"   => $this->createdBy->name,
                "updated_at"   => $this->updated_at->format('Y-m-d H:i:s'),
                "updated_by"   => $this->updatedBy->name
            ]
        ];
    }
}
