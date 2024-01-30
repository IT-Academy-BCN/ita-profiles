<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RecruiterController;
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
        return response()->json([
            [
                "nombreCompleto" => "Juan Pérez",
                "profesion" => "Desarrollador Frontend",
                "foto" => asset('img/stud_2.png'),
                "lenguajes" => ["JavaScript", "React", "HTML", "CSS"],
                "id" => 1
            ],
            [
                "nombreCompleto" => "María García",
                "profesion" => "Diseñadora UX/UI",
                "foto" => asset('img/stud_1.png'),
                "lenguajes" => ["CSS", "Sketch", "InVision"],
                "id" => 2
            ],
            [
                "nombreCompleto" => "Carlos Rodríguez",
                "profesion" => "Ingeniero de Software",
                "foto" => asset('img/stud_3.png'),
                "lenguajes" => ["Java", "PHP", "JavaScript", "React"],
                "id" => 3
            ],
            [
                "nombreCompleto" => "Laura Martínez",
                "profesion" => "Desarrolladora Full Stack",
                "foto" => asset('img/stud_1.png'),
                "lenguajes" => ["JavaScript", "Node.js", "Express", "SQL"],
                "id" => 4
            ],
            [
                "nombreCompleto" => "Elena López",
                "profesion" => "Frontend React",
                "foto" =>asset('img/stud_2.png'),
                "lenguajes" => ["CSS", "React", "Figma"],
                "id" => 5
            ],
            [
                "nombreCompleto" => "Alejandro Ruiz",
                "profesion" => "Desarrollador Frontend",
                "foto" =>asset('img/stud_3.png'),
                "lenguajes" => ["JavaScript", "Vue.js", "HTML", "CSS"],
                "id" => 6
            ],
            [
                "nombreCompleto" => "Sofía Hernández",
                "profesion" => "Diseñadora Gráfica",
                "foto" => asset('img/stud_1.png'),
                "lenguajes" => ["Illustrator", "Photoshop", "InDesign"],
                "id" => 7
            ],
            [
                "nombreCompleto" => "Martín González",
                "profesion" => "Ingeniero de Software",
                "foto" => asset('img/stud_2.png'),
                "lenguajes" => ["Java", "PHP", "JavaScript", "React"],
                "id" => 8
            ],
            [
                "nombreCompleto" => "Ana Castro",
                "profesion" => "Desarrolladora Full Stack",
                "foto" =>asset('img/stud_3.png'),
                "lenguajes" => ["JavaScript", "Node.js", "Express", "SQL"],
                "id" => 9
            ],
            [
                "nombreCompleto" => "Javier Díaz",
                "profesion" => "Analista de Datos",
                "foto" => asset('img/stud_1.png'),
                "lenguajes" => ["Python", "Pandas", "SQL"],
                "id" => 10
            ],
        ]);
    });

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

    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

   

});