<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    AdditionalTrainingListController,
    DevelopmentListController,
    ModalityController,
    StudentListController,
    StudentCollaborationController,
    StudentProjectsDetailController,
    StudentBootcampDetailController,
    StudentDetailController,
    TagController,
    SpecializationListController,
    StudentLanguagesDetailController
};

Route::get('/development/list', DevelopmentListController::class)->name('development.list');
Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');

Route::get('student/resume/list', StudentListController::class)->name('students.list');
Route::prefix('student/{studentId}/resume')->group(function () {
    Route::get('detail', StudentDetailController::class)->name('student.detail');
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
