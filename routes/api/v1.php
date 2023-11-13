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

Route::post('/login', [StudentController::class, 'login'])->name('student.login');
Route::post('/students', [StudentController::class, 'store'])->name('student.create');
Route::get('/students', [StudentController::class, 'index'])->name('students.list');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('student.show');


Route::middleware(['auth:api'])->group(function () {

    Route::put('/students/{id}', [StudentController::class, 'update']) -> middleware('can:update.student') -> name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy']) -> middleware('can:delete.student') -> name('student.delete');

});
