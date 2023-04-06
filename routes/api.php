<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth']], function() {
    
    Route::group(['prefix' => 'org'], function () {
        Route::post('store', [OrgController::class, 'store'])->name('org.store');

    });

    // add user by roles
    Route::group(['prefix' => 'users'], function() {
        Route::post('teacher', [UsersController::class, 'storeTeacher'])->name('users.store_teacher');
        // Route::post('student', [UsersController::class, 'storeStudent'])->name('users.store_student');
        // Route::post('store', [UsersController::class, 'sss'])->name('users.sss');

    });
});