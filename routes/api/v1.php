<?php

use App\Http\Controllers\api\AdditionalTrainingListController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DevelopmentListController;
use App\Http\Controllers\api\ModalityController;
use App\Http\Controllers\api\RecruiterController;
use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\api\StudentListController;
use App\Http\Controllers\api\StudentCollaborationController;
use App\Http\Controllers\api\StudentProjectsDetailController;
use App\Http\Controllers\api\StudentBootcampDetailController;
use App\Http\Controllers\api\StudentDetailController;
use App\Http\Controllers\api\TagController;
use App\Http\Controllers\api\SpecializationListController;
use App\Http\Controllers\api\StudentLanguagesDetailController;
use App\Http\Controllers\TermsAndConditionsController;
use Illuminate\Support\Facades\Route;
use LaravelLang\Publisher\Console\Add;

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
Route::get('/terms-and-conditions', [TermsAndConditionsController::class, 'getTermsAndConditions'])->name('terms-and-conditions');
Route::post('/students', [StudentController::class, 'store'])->name('student.create');
Route::get('/students', [StudentController::class, 'index'])->name('students.list');
Route::get('/students/{id}', [StudentController::class, 'show'])->name('student.show');

// Students Home
Route::get('/student/list/for-home', StudentListController::class)->name('profiles.home');
Route::get('/student/{id}/detail/for-home', StudentDetailController::class)->name('student.detail');
Route::get('/students/{student}/projects', StudentProjectsDetailController::class)->name('projects.list');
Route::get('/students/{student}/collaborations', StudentCollaborationController::class)->name('collaborations.list');
Route::get('/students/{id}/bootcamp', StudentBootcampDetailController::class)->name('bootcamp.list');
Route::get('/students/{student}/additionaltraining', AdditionalTrainingListController::class)->name('additionaltraining.list');
Route::get('/students/{id}/languages', StudentLanguagesDetailController::class)->name('languages.list');
Route::get('/modality/{studentId}', ModalityController::class)->name('modality');
// Fake endpoint development
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
// Specialization List Endpoint
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
// ! OLD ROUTES BLOCK
