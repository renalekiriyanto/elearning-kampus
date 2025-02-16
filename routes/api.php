<?php

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\MaterialsController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Auth user
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    // Courses
    Route::prefix('courses')->group(function(){
        Route::get('/', [CourseController::class, 'courses'])->middleware(['permission:read-courses']);
        Route::post('/', [CourseController::class, 'createCourses'])->middleware(['permission:create-courses']);
        Route::put('/{courses}', [CourseController::class, 'updateCourses'])->middleware(['permission:update-courses']);
        Route::delete('/{courses}', [CourseController::class, 'deleteCourses'])->middleware(['permission:delete-courses']);
        Route::post('/{courses}/enroll', [CourseController::class, 'enrollCourses'])->middleware(['permission:register-courses']);
    });
    // Materials
    Route::prefix('materials')->group(function(){
        Route::post('/', [MaterialsController::class, 'uploadMaterials'])->middleware(['permission:upload-materials']);
        Route::get('/{materials}/download', [MaterialsController::class, 'downloadMaterials'])->middleware(['permission:upload-materials']);
    });
    // Logged out
    Route::post('logout', [UserController::class, 'logout']);
});
