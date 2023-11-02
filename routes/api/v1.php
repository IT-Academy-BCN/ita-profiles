<?php

use App\Http\Controllers\api\StudentController;
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

//Route::get('/skins/available', [SkinController::class, 'index'])->name('skins.available');
