<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /*
    @route  GET     /api/courses
    @desc   Fetching courses
    @access permission:read-courses
    */
    public function courses(){
        try {
            $courses = Course::all();

            return response()->json([
                'success' => true,
                'msg' => 'Fetch courses',
                'data' => $courses
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /*
    @route  POST    /api/courses
    @desc   Create courses
    @access permission::create-courses
    */
    public function createCourses(Request $request){
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string']
            ]);

            $course = Course::create([
                'name' => $request->name,
                'description' => $request->description ?? null,
                'lecturer_id' => Auth::user()->id
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Courses created',
                'data' => $course
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /*
    @route  PUT    /api/courses
    @desc   Update courses
    @access permission::update-courses
    */
    public function updateCourses(Request $request, Course $courses){
        try {
            $valid = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string']
            ]);

            return response()->json([
                'valid' => $valid
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Courses created',
                'data' => $course
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
