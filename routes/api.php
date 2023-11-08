<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\{
    EmployeeController,
    ProjectController,
    RoleController,
    UserController,
    TaskStatusController,
    TaskController,
    SubtaskController,
};
use Illuminate\Support\Facades\Artisan;

Route::group(["middleware" => ["throttle:30,1"]], function () {
    /*======PUBLIC ROUTES=====*/

    //Clear all cache
    Route::get('/clear-all-cache', function () {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('route:clear');
        Artisan::call('clear-compiled');

        return "cache cleared";
    });

    // auth
    Route::group(["prefix" => "auth"], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    /*=====PROTECTED ROUTES=====*/
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // auth
        Route::group(["prefix" => "auth"], function () {
            Route::post("logout", [AuthController::class, 'logout']);
        });

        // users
        Route::apiResource('users', UserController::class);

        // employees
        Route::get('/employees/{employee}/managers-up-to-founder', [EmployeeController::class, "getManagersUpToFounder"]);
        Route::apiResource('employees', EmployeeController::class);

        // task-statuses
        Route::get('task-statuses', TaskStatusController::class);
    });
});

// CAllBACK ROUTES
Route::fallback(function () {
    return response()->json([
        'result' => false,
        'status' => 404,
        'message' => "Invalid route.",
    ], 404);
});
