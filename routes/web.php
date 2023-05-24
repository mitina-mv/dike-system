<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DisciplineController;

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

    // profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    // add user by roles
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');

        Route::get('teacher', [UsersController::class, 'createTeacher'])->name('users.createTeacher');
        Route::get('student', [UsersController::class, 'createStudent'])->name('users.createStudent');
        
        Route::post('student', [UsersController::class, 'storeStudent'])->name('users.store_student');
        Route::post('teacher', [UsersController::class, 'storeTeacher'])->name('users.store_teacher');

        Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.delete');

    });

    // question CRUD
    Route::group(['prefix' => 'question'], function() {
        Route::get('/', [QuestionController::class, 'index'])->name('question.index');
        Route::get('/create', [QuestionController::class, 'formCreate'])->name('question.formCreate');
        Route::post('/create', [QuestionController::class, 'create'])->name('question.create');
        Route::get('/{id}', [QuestionController::class, 'read'])->name('question.read');
        Route::post('/{id}', [QuestionController::class, 'update'])->name('question.update');
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('question.delete');
    });

    // question CRUD
    Route::group(['prefix' => 'discipline'], function() {
        Route::get('/', [DisciplineController::class, 'index'])->name('discipline.index');
        Route::post('/', [DisciplineController::class, 'create'])->name('discipline.create');
    });
});
// 

require __DIR__.'/auth.php';
