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
use App\Http\Controllers\api\{
    AdditionalTrainingListController,
    DevelopmentListController,
    ModalityController,
    RegisterController,
    StudentListController,
    StudentCollaborationController,
    StudentProjectsDetailController,
    StudentBootcampDetailController,
    StudentDetailController,
    TagController,
    SpecializationListController,
    StudentLanguagesDetailController
};
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');

Route::get('student/resume/list', StudentListController::class)->name('students.list');
Route::prefix('student/{studentId}/resume')->group(function () {
    Route::get('detail', StudentDetailController::class)->name('student.details');
    Route::get('projects', StudentProjectsDetailController::class)->name('student.projects');
    Route::get('collaborations', StudentCollaborationController::class)->name('student.collaborations');
    Route::get('bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
    Route::get('additionaltraining', AdditionalTrainingListController::class)->name('student.additionaltraining');
    Route::get('languages', StudentLanguagesDetailController::class)->name('student.languages');
    Route::get('modality', ModalityController::class)->name('student.modality');
});

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('tag.index');
    Route::post('/', [TagController::class, 'store'])->name('tag.create');
    Route::get('/{id}', [TagController::class, 'show'])->name('tag.show');
    Route::put('/{id}', [TagController::class, 'update'])->name('tag.update');
});
// ! OLD ROUTES BLOCK
Route::get('/student/list/for-home', StudentListController::class)->name('profiles.home');
Route::get('/student/{id}/detail/for-home', StudentDetailController::class)->name('student.detail');
Route::get('/students/{student}/projects', StudentProjectsDetailController::class)->name('projects.list');
Route::get('/students/{student}/collaborations', StudentCollaborationDetailController::class)->name('collaborations.list');
Route::get('/students/{id}/bootcamp', StudentBootcampDetailController::class)->name('bootcamp.list');
Route::get('/students/{student}/additionaltraining', StudentAdditionalTrainingListController::class)->name('additionaltraining.list');
Route::get('/students/{id}/languages', StudentLanguagesDetailController::class)->name('languages.list');
Route::get('/modality/{studentId}', StudentModalityController::class)->name('modality');
// Fake endpoint development
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
// Specialization List Endpoint
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
// ! OLD ROUTES BLOCK
