<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class EmployeeJobCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'result'  => true,
            'message' => "Employee Jobs fetched successfully!",
            'status'  => Response::HTTP_OK,
            "count"   => $this->collection->count(),
            'data'    => $this->collection->map(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    "create_at" => $data->created_at->format('Y-m-d H:i:s'),
                    "update_at" => $data->updated_at->format('Y-m-d H:i:s'),
                    "created_by" => $data->createdBy->name,
                    "updated_by" => $data->updatedBy->name,
                ];
            }),
        ];
    }
}
