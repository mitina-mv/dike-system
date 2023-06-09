<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentTestController;
use App\Http\Controllers\StudgroupController;
use App\Http\Controllers\TestController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

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
    Route::group(['prefix' => 'group', 'middleware' => ['role.admin']], function() {
        Route::get('create', [StudgroupController::class, 'index'])->name('group.create');
        Route::post('create', [StudgroupController::class, 'create']);
    });

    // profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });
    
    // add user by roles
    Route::group(['prefix' => 'users', 'middleware' => ['role.admin']], function() {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');

        Route::get('teacher', [UsersController::class, 'createTeacher'])->name('users.createTeacher');
        Route::get('student', [UsersController::class, 'createStudent'])->name('users.createStudent');
        
        Route::post('student', [UsersController::class, 'storeStudent'])->name('users.store_student');
        Route::post('teacher', [UsersController::class, 'storeTeacher'])->name('users.store_teacher');

        Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.delete');

    });

    // question CRUD
    Route::group(['prefix' => 'question', 'middleware' => ['role.no.student']], function() {
        Route::get('/', [QuestionController::class, 'index'])->name('question.index');
        Route::get('/create', [QuestionController::class, 'formCreate'])->name('question.formCreate');
        Route::post('/create', [QuestionController::class, 'create'])->name('question.create');
        Route::get('/{id}', [QuestionController::class, 'read'])->name('question.read');
        Route::post('/{id}', [QuestionController::class, 'update'])->name('question.update');
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('question.delete');
    });

    // discipline CRUD
    Route::group(['prefix' => 'discipline', 'middleware' => ['role.no.student']], function() {
        Route::get('/', [DisciplineController::class, 'index'])->name('discipline.index');
        Route::post('/', [DisciplineController::class, 'create'])->name('discipline.create');
    });

    // test CRUD
    Route::group(['prefix' => 'test', 'middleware' => ['role.teacher']], function() {
        Route::get('/', [TestController::class, 'index'])->name('tests.index');

        Route::get('/create', [TestController::class, 'formCreate'])->name('tests.formCreate');
        Route::post('/create', [TestController::class, 'create'])->name('tests.create');
        
        Route::get('/{id}', [TestController::class, 'read'])->name('tests.read');
        Route::post('/{id}', [TestController::class, 'update'])->name('tests.update');
        Route::delete('/{id}', [TestController::class, 'destroy'])->name('tests.delete');
    });

    // назначение тестирований
    Route::group(['prefix' => 'assignment', 'middleware' => ['role.teacher']], function() {
        // все, что когда либо назначали
        Route::get('/', [AssignmentController::class, 'index'])->name('assignment.index');
        Route::get('/{year}', [AssignmentController::class, 'list'])->where('year', '[0-9]+');

        // список студентов, кому назначен тест
        Route::get('/{test_id}/{date}', [AssignmentController::class, 'read']);
        // удаление всего назначения 
        Route::delete('/{test_id}/{date}', [AssignmentController::class, 'destroyAll']);
        
        // форма назначения - отдать всех пользователей по группам
        Route::get('/create', [AssignmentController::class, 'formCreate'])->name('assignment.formCreate');
        Route::post('/create', [AssignmentController::class, 'create'])->name('assignment.create');

        // менять нельзя, только удалять
        Route::delete('/{id}', [AssignmentController::class, 'destroy'])->name('assignment.delete');
    });

    // список тестирований
    Route::group(['prefix' => 'student-test', 'middleware' => ['role.student']], function() {
        // все назначения (фильтра по дисциплинам)
        Route::get('/', [StudentTestController::class, 'index'])->name('studenttest.index');
    });

    //само тестирование студента
    Route::group(['prefix' => 'testing', 'middleware' => ['role.student']], function() {
        // получение плана теста
        Route::get('/{testlog_id}', [StudentTestController::class, 'testing'])->name('testing.index');
        // фиксирование результата
        Route::post('/{testlog_id}', [StudentTestController::class, 'writeResult']);
    });

    // отчеты
    Route::group(['prefix' => 'reports'], function() {
        // детальный отчет по тестированию
        Route::get('/testlog/{testlog_id}', [ReportController::class, 'studentDetailReport'])->name('report.student');
        // отчет по группам
        Route::get('/studgroups/{test_id}/{date}', [ReportController::class, 'studgroupsTestReport'])->name('report.studgroups');

        // создание pdf
        Route::get('/generate/testlog/{testlog_id}', [ReportController::class, 'generate_testlog'])->name('report.generate_testlog');
        Route::get('/generate/studgroups/{test_id}/{date}', [ReportController::class, 'generate_studgroups'])->name('report.generate_studgroups');
    });
});
// 

require __DIR__.'/auth.php';
