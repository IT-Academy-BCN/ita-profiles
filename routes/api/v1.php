<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\{
    AdditionalTrainingListController,
    AdminController,
    AuthController,
    DevelopmentListController,
    ModalityController,
    RecruiterController,
    StudentController,
    StudentListController,
    StudentCollaborationController,
    StudentProjectsDetailController,
    StudentBootcampDetailController,
    StudentDetailController,
    TagController,
    SpecializationListController,
    StudentLanguagesDetailController
};

//!BLOQUE ACTUALIZADO
//No Auth
Route::prefix('student/resume')->group(function () {
    Route::get('/list', StudentListController::class)->name('students.list');
    Route::get('/{studentId}/detail', StudentDetailController::class)->name('student.detail');
    Route::get('/{studentId}/projects', StudentProjectsDetailController::class)->name('student.projects');
    Route::get('/{studentId}/collaborations', StudentCollaborationController::class)->name('student.collaborations');
    Route::get('/{studentId}/bootcamp', StudentBootcampDetailController::class)->name('student.bootcamp');
    Route::get('/{studentId}/additionaltraining', AdditionalTrainingListController::class)->name('student.additionaltraining');
    Route::get('/{studentId}/languages', StudentLanguagesDetailController::class)->name('student.languages');
    Route::get('/{studentId}/modality', ModalityController::class)->name('student.modality');

});
    Route::get('/development/list', DevelopmentListController::class)->name('development.list');
    Route::get('/specialization/list', SpecializationListController::class)->name('roles.list');
//!BLOQUE ACTUALIZADO

//No Auth
Route::get('/tags', [TagController::class, 'index'])->name('tag.index');

//Passport Auth with token
Route::middleware('auth:api')->group(function () {
    //Student
    //? Route::put('/students/{id}', [StudentController::class, 'update'])->middleware('can:update.student')->name('student.update');
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
    Route::post('/tags', [TagController::class, 'store'])->middleware('role:admin')->name('tag.create');
    Route::get('/tags/{id}', [TagController::class, 'show'])->middleware('role:admin')->name('tag.show');
    Route::put('/tags/{id}', [TagController::class, 'update'])->middleware('role:admin')->name('tag.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->middleware('role:admin')->name('tag.destroy');

    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
