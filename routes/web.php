<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::prefix('courses')->group(function(){
        Route::get('/', [CourseController::class, 'courses'])->name('courses');
        // Create
        Route::get('/create', [CourseController::class, 'createCourses'])->name('courses.create');
        Route::post('/', [CourseController::class, 'storeCourses'])->name('courses.store');
        // Delete
        Route::delete('/{course}', [CourseController::class, 'deleteCourses'])->name('courses.delete');
    });
});
