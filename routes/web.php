<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrgController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('org', [OrgController::class, 'create'])->name('org.create');
Route::post('org', [OrgController::class, 'store'])->name('org.store');

require __DIR__.'/auth.php';
