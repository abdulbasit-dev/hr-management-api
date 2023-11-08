<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class EmployeeCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'result' => true,
            'message' => "Employees fetched successfully!",
            'status' => Response::HTTP_OK,
            'total' => $this->collection->count(),
            'data' => $this->collection->map(function ($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    "create_at" => $task->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ];
    }
}
