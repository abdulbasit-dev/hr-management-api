<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ManagerCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'result'  => true,
            'message' => "Employees fetched successfully!",
            'status'  => Response::HTTP_OK,
            "total" => $this->collection->count(),
            'data'    => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    "email" => $data->email,
                    "job_title" => $data->job->name ?? null,
                    "manager_id" => $data->manager_id,
                    "manager_name" => $data->manager->name ?? null,
                    "age" => $data->age,
                    "gender" => $data->gender->getLabelText(),
                    "hire_date" => Carbon::parse($data->hire_date)->format('Y-m-d'),
                    "salary" => $data->salary,
                    "create_at" => $data->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ];
    }
}
