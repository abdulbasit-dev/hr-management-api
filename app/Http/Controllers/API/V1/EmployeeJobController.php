<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeJobRequest;
use App\Http\Resources\EmployeeJobCollection;
use App\Http\Resources\EmployeeJobResource;
use App\Models\EmployeeJob;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeJobController extends Controller
{

    public function index()
    {
        $jobs = EmployeeJob::get();

        return new EmployeeJobCollection($jobs);
    }

    public function store(EmployeeJobRequest $request)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $job = EmployeeJob::create($validated);

            // commit transaction
            DB::commit();
            return $this->jsonResponse(true, __('Job created successfully!'), Response::HTTP_CREATED, $job);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();
            throw $th;
        }
    }

    public function update(EmployeeJobRequest $request, EmployeeJob $job)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            $job->update($validated);

            // commit transaction
            DB::commit();
            return $this->jsonResponse(true, __('Job updated successfully!'), Response::HTTP_OK, $job);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }

    public function destroy(EmployeeJob $job)
    {
        // begin transaction
        DB::beginTransaction();
        try {
            $job->delete();

            // commit transaction
            DB::commit();

            return $this->jsonResponse(true, __('Job deleted successfully!'), Response::HTTP_OK);
        } catch (\Throwable $th) {
            // rollback transaction
            DB::rollBack();

            throw $th;
        }
    }
}
