<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
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

            $courses->update($valid);

            return response()->json([
                'success' => true,
                'msg' => 'Courses updated',
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
    @route  DELETE    /api/courses
    @desc   Delete courses
    @access permission::delete-courses
    */
    public function deleteCourses(Course $courses){
        try {
            $courses->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Courses deleted'
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
    @route  POST    /api/courses/{id}/enroll
    @desc   Enroll courses
    @access permission::registers-courses
    */
    public function enrollCourses(Course $courses){
        try {
            // Check enroll
            $enroll = Enrollment::where('course_id', $courses->id)->where('student_id', Auth::user()->id)->first();
            if($enroll){
                return response()->json([
                    'success' => false,
                    'msg' => 'User have already enrolled in this courses',
                ], 409);
            }

            $enroll  = Enrollment::create([
                'course_id' => $courses->id,
                'student_id' => Auth::user()->id
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Course enrolled',
                'data' => $enroll,
                'course' => $courses
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
