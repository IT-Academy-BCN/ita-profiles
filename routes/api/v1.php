<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Student\{
    AddStudentImageController,
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
use App\Http\Controllers\api\Message\SendMessageController;

Route::post('/register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::get('/development/list', DevelopmentListController::class)->name('development.list');
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
Route::get('student/resume/list', StudentListController::class)->name('students.list');

Route::prefix('student/{student}/resume')->group(function () {
    Route::get('languages', StudentLanguagesDetailController::class)->name('student.languages');
    Route::get('detail', StudentDetailController::class)->name('student.details');
    Route::get('bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
    Route::get('projects', StudentProjectsDetailController::class)->name('student.projects');
    Route::get('additionaltraining', StudentAdditionalTrainingListController::class)->name('student.additionaltraining');
    Route::get('collaborations', StudentCollaborationDetailController::class)->name('student.collaborations');
    Route::get('modality', StudentModalityController::class)->name('student.modality');
    Route::get('photo', GetStudentImageController::class)->name('student.photo.get');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::prefix('student/{student}/resume')->group(function () {
        Route::put('profile', UpdateStudentProfileController::class)->name('student.updateProfile');
        Route::put('projects/{project}', UpdateStudentProjectController::class)->name('student.updateProject');
        Route::post('languages', AddStudentLanguageController::class)->name('student.addLanguage');
        Route::put('collaborations', UpdateStudentCollaborationsController::class)->name('student.updateCollaborations');
        Route::put('languages', UpdateStudentLanguagesController::class)->name('student.languages.update');
        Route::put('photo', UpdateStudentImageController::class)->name('student.updatePhoto');
        Route::post('photo', AddStudentImageController::class)->name('student.addPhoto');
        Route::delete('languages/{language}', DeleteStudentResumeLanguageController::class)->name('student.language.delete');
    });
    Route::prefix('messages')->group(function () {
        Route::post('/', SendMessageController::class)->name('message.send');
    });
});

Route::prefix('tags')->group(function () {
    Route::get('/', TagListController::class)->name('tag.list');
    Route::post('/', TagStoreController::class)->name('tag.store');
    Route::get('/{tag}', TagDetailController::class)->name('tag.detail');
    Route::put('/{tag}', TagUpdateController::class)->name('tag.update');
});
