<?php

use App\Http\Controllers\api\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecruiterController;

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

Route::post('/recruiter', [RecruiterController::class, 'store'])->name('recruiter.create');
Route::get('/recruiter', [RecruiterController::class, 'index'])->name('recruiter.list');
Route::get('/recruiters/{id}', [RecruiterController::class, 'show'])->name('recruiter.show');
Route::put('/recruiters/{id}', [RecruiterController::class, 'update'])->name('recruiter.update');
Route::delete('/recruiters/{id}', [RecruiterController::class, 'destroy'])->name('recruiter.delete');



//Route::get('/skins/available', [SkinController::class, 'index'])->name('skins.available');
