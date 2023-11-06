<?php

use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\api\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/students', [StudentController::class, 'store'])->name('student.create');
Route::get('/students', [StudentController::class, 'index'])->name('students.list');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.create');
Route::get('/admins', [AdminController::class, 'index'])->middleware('role:admin')->name('admin.index');
Route::get('/admins/{id}', [AdminController::class, 'show'])->middleware('role:admin')->name('admin.show');
Route::put('/admins/{id}', [AdminController::class, 'update'])->middleware('role:admin')->name('admin.update');
Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->middleware('role:admin')->name('admin.destroy'););
//Route::get('/skins/available', [SkinController::class, 'index'])->name('skins.available');
