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

use App\Http\Middleware\{
    EnsureStudentOwner
};

Route::post('/register', [RegisterController::class, 'register'])->name('user.register');
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

Route::get('student/resume/list', StudentListController::class)->name('students.list');

Route::get('student/{student}/resume/languages', StudentLanguagesDetailController::class)->name('student.languages');

Route::get('student/{student}/resume/detail', StudentDetailController::class)->name('student.details');
Route::put('student/{student}/resume/profile', UpdateStudentProfileController::class)->name('student.updateProfile');
Route::get('student/{student}/resume/bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
Route::get('student/{student}/resume/projects', StudentProjectsDetailController::class)->name('student.projects');
Route::put('student/{student}/resume/projects/{project}', UpdateStudentProjectController::class)->middleware('auth:api')->name('student.updateProject');
Route::post('student/{student}/resume/languages', AddStudentLanguageController::class)->name('student.addLanguage');
Route::get('student/{student}/resume/additionaltraining', StudentAdditionalTrainingListController::class)->name('student.additionaltraining');
Route::get('student/{student}/resume/collaborations', StudentCollaborationDetailController::class)->name('student.collaborations');
Route::put('student/{student}/resume/collaborations', UpdateStudentCollaborationsController::class)->name('student.updateCollaborations');
Route::put('student/{student}/resume/photo', UpdateStudentImageController::class)->name('student.updatePhoto');
Route::post('student/{student}/resume/photo', UpdateStudentImageController::class)->name('student.createPhoto');

Route::prefix('student/{studentId}/resume')->group(function () {
    Route::put('languages', UpdateStudentLanguagesController::class)->name('student.languages.update');
    Route::get('modality', StudentModalityController::class)->name('student.modality');
    Route::get('photo', GetStudentImageController::class)->middleware('auth:api', EnsureStudentOwner::class)->name('student.photo.get');
    Route::delete('languages/{languageId}', DeleteStudentResumeLanguageController::class)->name('student.language.delete');
});

Route::prefix('tags')->group(function () {
    Route::get('/', TagListController::class)->name('tag.list');
    Route::post('/', TagStoreController::class)->name('tag.store');
    Route::get('/{tagId}', TagDetailController::class)->name('tag.detail');
    Route::put('/{tagId}', TagUpdateController::class)->name('tag.update');
});
