<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ManagerCollection;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $limit = request()->limit ?? static::ITEM_PER_PAGE;

        $employees = Employee::paginate($limit);

        return new EmployeeCollection($employees);
    }

    public function search()
    {
        $searchParams = request()->all();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $name  = Arr::get($searchParams, 'name', null);
        $salary = Arr::get($searchParams, 'salary', null);

        $employees = Employee::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($salary, function ($query, $salary) {
                return $query->where('salary', 'like', "%{$salary}%");
            })
            ->paginate($limit);

        return new EmployeeCollection($employees);
    }

    public function mangers()
    {
        // return all employees (managers) who are manager on other employees
        $managers = Employee::whereHas('employees', function ($query) {
            $query->where('manager_id', '!=', null);
        })->get();

        return new ManagerCollection($managers);
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


    public function getManagersUpToFounder(Employee $employee)
    {
        //  Create an Endpoint to Find the given employee’s managers up to the founder ,
        // for example: Oswald Little is an employee , Destinee King is his manager and Dr. Anibal D'Amore is the founder,

        $founderName = Employee::where('is_founder', true)->value("name") ?? "Not Founder";

        $data = [
            $employee->name,
            $employee->manager->name,
            $founderName
        ];

        return $this->jsonResponse(true, "Employee's managers up to the founder", Response::HTTP_OK, $data);
    }

    public function getManagersUpToFounderSalary(Employee $employee)
    {

        $founder = Employee::where('is_founder', true)->first();

        $data = [
            $employee->name => $employee->salary,
            $employee->manager->name => $employee->manager->salary,
            $founder->name => $founder->salary
        ];

        return $this->jsonResponse(true, "Employee's managers up to the founder salary", Response::HTTP_OK, $data);
    }
}
