<?php

namespace App\Imports;

use App\Enums\Gender;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithStartRow, WithChunkReading, WithHeadingRow
{

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function model(array $row)
    {
        try {
            Log::info($row);
            return Employee::firstOrCreate(
                [
                    "email" => $row["email"],
                ],
                [
                    "name" => $row["name"],
                    "age" => $row["age"],
                    "job_id" => EmployeeJob::where("name", $row["job_title"])->first()->id ?? null,
                    "manager_id" => Employee::where("name", $row["manager_name"])->first()->id ?? null,
                    "gender" => Gender::fromName($row["gender"]),
                    "hire_date" => $row["hire_date"],
                    "salary" => $row["salary"],
                ]
            );
        } catch (\Throwable $th) {
            Log::error('An error occurred while creating the task: ' . $th->getMessage());
            throw $th;
        }
    }
}
