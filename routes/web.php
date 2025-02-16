<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'loginAuth'])->name('login.post');

Route::middleware(['auth'])->group(function(){
    // Courses
    Route::prefix('courses')->group(function(){
        Route::get('/', [CourseController::class, 'courses'])->name('courses')->middleware('permission:read-courses');
        // Create
        Route::get('/create', [CourseController::class, 'createCourses'])->name('courses.create')->middleware('permission:create-courses');
        Route::post('/', [CourseController::class, 'storeCourses'])->name('courses.store');
        // Delete
        Route::delete('/{course}', [CourseController::class, 'deleteCourses'])->name('courses.delete');
        Route::post('/{courses}/enroll', [CourseController::class, 'enrollCourses'])->name('courses.enrolled')->middleware(['permission:register-courses']);
    });
    // Materials
    Route::prefix('materials')->group(function(){
        Route::get('/', [MaterialsController::class, 'pageMaterials'])->name('materials')->middleware('permission:read-materials');
        Route::post('/', [MaterialsController::class, 'uploadMaterials'])->name('materials.store')->middleware('permission:upload-materials');
        Route::get('/{materials}/download', [MaterialsController::class, 'downloadMaterials'])->name('materials.download')->middleware(['permission:download-materials']);
        Route::get('/create', [MaterialsController::class, 'createMaterial'])->name('materials.create')->middleware('permission:upload-materials');
    });
    // Assignment
    Route::prefix('assignments')->group(function(){
        Route::get('/', [AssignmentController::class, 'pageAssignment'])->name('assignments')->middleware('permission:read-assignments');
        Route::get('/create', [AssignmentController::class, 'pageCreateAssignment'])->name('assignment.create')->middleware('permission:create-assignments');
        Route::post('/', [AssignmentController::class, 'createAssignment'])->name('assignment.store')->middleware('permission:create-assignments');
    });
    // Logout
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});
