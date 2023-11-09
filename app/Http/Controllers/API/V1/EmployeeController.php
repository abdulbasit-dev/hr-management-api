<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::paginate(10);

        return new EmployeeCollection($employees);
    }

    public function search()
    {
        $employees = Employee::paginate(10);

        return new EmployeeCollection($employees);
    }

    public function mangers()
    {
        // $employees = Employee::paginate(10);

        // return new EmployeeCollection($employees);
    }

    public function store(EmployeeRequest $request)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $employee = Employee::create($validated);

            // commit transaction
            DB::commit();
            return $this->jsonResponse(true, __('Employee created successfully!'), Response::HTTP_CREATED, $employee);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();
            throw $th;
        }
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $employee->update($validated);

            // commit transaction
            DB::commit();
            return $this->jsonResponse(true, __('Employee updated successfully!'), Response::HTTP_OK, $employee);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }

    public function destroy(Employee $employee)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $employee->delete();

            // commit transaction
            DB::commit();

            return $this->jsonResponse(true, __('Employee deleted successfully!'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }

    // Within your controller
    public function getManagersUpToFounder($employeeId)
    {
        $employee = Employee::find($employeeId);
        $managers = [];

        while ($employee && !$employee->is_founder) {
            $managers[] = $employee->name;
            $employee = Employee::find($employee->manager_id);
        }

        if ($employee) {
            $managers[] = $employee->name; // Include the founder
        }

        return $managers;
    }
}
