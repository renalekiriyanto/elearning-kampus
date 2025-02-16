<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'loginAuth'])->name('login.post');

Route::middleware(['auth'])->group(function(){
    Route::prefix('courses')->group(function(){
        Route::get('/', [CourseController::class, 'courses'])->name('courses')->middleware('permission:read-courses');
        // Create
        Route::get('/create', [CourseController::class, 'createCourses'])->name('courses.create')->middleware('permission:create-courses');
        Route::post('/', [CourseController::class, 'storeCourses'])->name('courses.store');
        // Delete
        Route::delete('/{course}', [CourseController::class, 'deleteCourses'])->name('courses.delete');
        Route::post('/{courses}/enroll', [CourseController::class, 'enrollCourses'])->name('courses.enrolled')->middleware(['permission:register-courses']);
    });
});
