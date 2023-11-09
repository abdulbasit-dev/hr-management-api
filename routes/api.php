<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\{
    EmployeeController,
    EmployeeJobController,
    UserController,
    GenderController,
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
        Route::get('/employees/mangers', [EmployeeController::class, "mangers"]);
        Route::apiResource('employees', EmployeeController::class);

        // jobs
        Route::apiResource('jobs', EmployeeJobController::class);

        // genders
        Route::get("genders", [GenderController::class,"__invoke"]);
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
