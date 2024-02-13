<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RecruiterController;
use App\Http\Controllers\api\ResumeController;
use App\Http\Controllers\api\SpecializationListController;
use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\api\TagController;
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

//No Auth
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/students', [StudentController::class, 'store'])->name('student.create');
Route::get('/students', [StudentController::class, 'index'])->name('students.list');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('student.show');

Route::post('/recruiters', [RecruiterController::class, 'store'])->name('recruiter.create');
Route::get('/recruiters', [RecruiterController::class, 'index'])->name('recruiter.list');
Route::get('/recruiters/{id}', [RecruiterController::class, 'show'])->name('recruiter.show');

//! ENDPOINT FALSO
Route::get('/fake-students', function () {
    $data = file_get_contents(base_path('database/data/students.json'));

    return response()->json(json_decode($data, true));
});

// Specialization List Endpoint
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');

//Admins Route
Route::post('/admins', [AdminController::class, 'store'])->name('admins.create');
//Passport Auth with token
Route::middleware('auth:api')->group(function () {
    //Student
    Route::put('/students/{id}', [StudentController::class, 'update'])->middleware('can:update.student')->name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->middleware('can:delete.student')->name('student.delete');
    //Recruiter
    Route::put('/recruiters/{id}', [RecruiterController::class, 'update'])->name('recruiter.update');
    Route::delete('/recruiters/{id}', [RecruiterController::class, 'destroy'])->name('recruiter.delete');
    //Admin
    Route::get('/admins/{id}', [AdminController::class, 'show'])->middleware('role:admin')->name('admin.show');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->middleware('role:admin')->name('admin.update');
    Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->middleware('role:admin')->name('admin.destroy');
    Route::get('/admins', [AdminController::class, 'index'])->middleware('role:admin')->name('admin.index');
    //Tags
    Route::get('/tags', [TagController::class, 'index'])->middleware('role:admin')->name('tag.index');
    Route::post('/tags', [TagController::class, 'store'])->middleware('role:admin')->name('tag.create');
    Route::get('/tags/{id}', [TagController::class, 'show'])->middleware('role:admin')->name('tag.show');
    Route::put('/tags/{id}', [TagController::class, 'update'])->middleware('role:admin')->name('tag.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->middleware('role:admin')->name('tag.destroy');
    //Resume
    Route::post('/resume',[ResumeController::class,'store'])->middleware('role:student')->name('resume.store');
    Route::get('/resume/{id}',[ResumeController::class,'show'])->middleware('role:student')->name("resume.show");
    Route::put('/resume/{id}', [ResumeController::class, 'update'])->middleware('role:student')->name('resume.update');
    Route::delete('/resume/{id}', [ResumeController::class, 'destroy'])->middleware('role:student')->name('resume.delete');
    

    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
