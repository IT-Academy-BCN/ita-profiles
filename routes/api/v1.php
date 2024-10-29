<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Student\{
    DeleteStudentResumeLanguageController,
    GetStudentImageController,
    StudentAdditionalTrainingListController,
    StudentModalityController,
    StudentBootcampDetailController,
    StudentCollaborationDetailController,
    StudentDetailController,
    StudentLanguagesDetailController,
    UpdateStudentLanguagesController,
    StudentListController,
    StudentProjectsDetailController,
    SpecializationListController,
    UpdateStudentCollaborationsController,
    UpdateStudentProjectController,
    UpdateStudentProfileController,
    UpdateStudentImageController,
    AddStudentLanguageController
};
use App\Http\Controllers\api\Tag\{
    TagListController,
    TagStoreController,
    TagDetailController,
    TagUpdateController,
    DevelopmentListController
};
use App\Http\Controllers\api\Auth\{
    RegisterController,
    AuthController
};
use App\Http\Middleware\EnsureStudentOwner;

Route::post('/register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
Route::get('student/resume/list', StudentListController::class)->name('students.list');

Route::prefix('student/{student}/resume')->group(function () {
    Route::get('languages', StudentLanguagesDetailController::class)->name('student.languages');
    Route::get('detail', StudentDetailController::class)->name('student.details');
    Route::put('profile', UpdateStudentProfileController::class)->name('student.updateProfile');
    Route::get('bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
    Route::get('projects', StudentProjectsDetailController::class)->name('student.projects');
    Route::put('projects/{project}', UpdateStudentProjectController::class)->middleware('auth:api')->name('student.updateProject');
    Route::post('languages', AddStudentLanguageController::class)->name('student.addLanguage');
    Route::get('additionaltraining', StudentAdditionalTrainingListController::class)->name('student.additionaltraining');
    Route::get('collaborations', StudentCollaborationDetailController::class)->name('student.collaborations');
    Route::put('collaborations', UpdateStudentCollaborationsController::class)->name('student.updateCollaborations');
    Route::put('languages', UpdateStudentLanguagesController::class)->name('student.languages.update');
    Route::put('photo', UpdateStudentImageController::class)->name('student.updatePhoto');
    Route::get('modality', StudentModalityController::class)->name('student.modality');
    Route::delete('languages/{language}', DeleteStudentResumeLanguageController::class)->name('student.language.delete');
});

Route::prefix('student/{studentId}/resume')->group(function () {
    Route::get('photo', GetStudentImageController::class)->middleware('auth:api', EnsureStudentOwner::class)->name('student.photo.get');
});

Route::prefix('tags')->group(function () {
    Route::get('/', TagListController::class)->name('tag.list');
    Route::post('/', TagStoreController::class)->name('tag.store');
    Route::get('/{tagId}', TagDetailController::class)->name('tag.detail');
    Route::put('/{tagId}', TagUpdateController::class)->name('tag.update');
});
