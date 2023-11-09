<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function collection()
    {
        return Employee::all();
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->name,
            $employee->email,
            $employee->age,
            $employee->gender->getLabelText(),
            $employee->job->name ?? null,
            $employee->salary,
            $employee->manager->name ?? null,
            Carbon::parse($employee->hire_date)->format('Y-m-d'),
            $employee->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        // Define the headings for the exported file
        return [
            'ID',
            'Name',
            'Email',
            'Age',
            "Gender",
            "Job Title",
            'Salary',
            "Manager Name",
            "Hire Date",
            "Created At"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
