<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\StudentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('student.manage');
})->name('welcome');

Route::get('/student/index', [StudentController::class, 'index'])->name('student.manage');
Route::get('/get-student-data', [StudentController::class, 'getTableData'])->name('get.student.data');
Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
