<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/{any}', 'SpaController@index')->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// orgs
Route::group(['prefix' => 'org'], function() {
    Route::get('/', [OrgController::class, 'create'])->name('org.create');

});

// 
Route::group(['middleware' => ['auth']], function() {
    // add student groups
    Route::group(['prefix' => 'group'], function() {
        Route::get('create', function(){
            return 'ddd';
        })->name('group.create');
    });
    // add user by roles
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UsersController::class, 'index'])->name('user.index');

        Route::get('teacher', [UsersController::class, 'createTeacher'])->name('user.createTeacher');
        Route::get('student', [UsersController::class, 'createStudent'])->name('user.createStudent');
        // Route::post('store', [UsersController::class, 'sss'])->name('users.sss');
        Route::post('student', [UsersController::class, 'storeStudent'])->name('users.store_student');
        Route::post('teacher', [UsersController::class, 'storeTeacher'])->name('users.store_teacher');

    });
});
// 

require __DIR__.'/auth.php';
