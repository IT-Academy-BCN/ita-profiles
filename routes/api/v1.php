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
    UpdateStudentSkillsController,
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

use App\Http\Controllers\api\{
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

Route::get('student/{student}/resume/detail', StudentDetailController::class)->name('student.details');
Route::get('student/{student}/resume/bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
Route::get('student/{student}/resume/projects', StudentProjectsDetailController::class)->name('student.projects');
Route::get('student/{student}/resume/additionaltraining', StudentAdditionalTrainingListController::class)->name('student.additionaltraining');

Route::prefix('student/{studentId}/resume')->group(function () {
    Route::get('collaborations', StudentCollaborationDetailController::class)->name('student.collaborations');
    Route::get('languages', StudentLanguagesDetailController::class)->name('student.languages');
    Route::put('languages', UpdateStudentLanguagesController::class)->name('student.languages.update');
    Route::get('modality', StudentModalityController::class)->name('student.modality');
    Route::get('photo', GetStudentImageController::class)->middleware('auth:api', EnsureStudentOwner::class)->name('student.photo.get');
    Route::put('projects/{projectId}', UpdateStudentProjectController::class)->middleware('auth:api', EnsureStudentOwner::class)->name('student.updateProject');
    Route::put('skills', UpdateStudentSkillsController::class)->middleware('auth:api', EnsureStudentOwner::class)->name('student.skills');
    Route::put('profile', UpdateStudentProfileController::class)->name('student.updateProfile');
    Route::post('photo', UpdateStudentImageController::class)->name('student.updatePhoto');
    Route::post('languages', AddStudentLanguageController::class)->name('student.addLanguage');
    Route::put('collaborations', UpdateStudentCollaborationsController::class)->name('student.updateCollaborations');
    Route::delete('languages/{languageId}', DeleteStudentResumeLanguageController::class)->name('student.language.delete');
});

Route::prefix('tags')->group(function () {
    Route::get('/', TagListController::class)->name('tag.list');
    Route::post('/', TagStoreController::class)->name('tag.store');
    Route::get('/{tagId}', TagDetailController::class)->name('tag.detail');
    Route::put('/{tagId}', TagUpdateController::class)->name('tag.update');
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
