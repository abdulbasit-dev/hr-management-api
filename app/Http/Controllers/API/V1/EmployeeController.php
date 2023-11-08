<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        // $this->authorize('view_project');

        $employees = Employee::paginate(10);

        return new EmployeeCollection($employees);
    }

    public function store(TaskRequest $request)
    {
        // $this->authorize('add_project');

        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $employee = Employee::create($validated);

            return $employee;

            // commit transaction
            // DB::commit();

            return $this->jsonResponse(true, __('Task created successfully!'), Response::HTTP_CREATED, $employee);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }

    public function show(Task $employee)
    {
        // $this->authorize('view_project');

        return new EmployeeResource($task);
    }

    public function update(TaskRequest $request, Employee $employee)
    {
        // $this->authorize('edit_project');

        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->safe()->except(['role']);

            $employee->update($validated);

            $employee->syncRoles($request->role);

            // commit transaction
            DB::commit();

            return $this->jsonResponse(true, __('Task updated successfully!'), Response::HTTP_OK, $employee);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }

    public function destroy(Task $employee)
    {
        // $this->authorize('delete_project');

        // begin transaction
        DB::beginTransaction();
        try {
            $employee->delete();

            // commit transaction
            DB::commit();

            return $this->jsonResponse(true, __('Task deleted successfully!'), Response::HTTP_OK);
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
