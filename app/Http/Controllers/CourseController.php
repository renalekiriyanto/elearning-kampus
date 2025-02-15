<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /*
    @route          GET /courses
    @description    List courses
    @access         Public
    */
    public function courses(){
        $data = Course::paginate(10);

        return view('courses.index', [
            'data' => $data
        ]);
    }

    /*
    @route          GET /create/courses
    @description    Create courses form
    @access         permission:create-courses
    */
    public function createCourses(){

        return view('courses.create');
    }

    /*
    @route          POST /courses
    @description    Create courses
    @access         permission:create-courses
    */
    public function storeCourses(Request $request){
        try {
            // Validation data
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['string']
            ]);

            // Set lecturer id by user authenticated
            $lecturer_id = Auth::user()->id;

            $course = Course::create([
                'name' => $request->name,
                'description' => $request->description,
                'lecturer_id' => $lecturer_id,
            ]);

            return redirect()->route('courses')->with('success', 'Course created');
        } catch (Exception $err) {
            return redirect()->route('courses')->with('error', $err->getMessage());
        }
    }

    /*
    @route          DELETE /courses/delete/{id}
    @description    Delete courses
    @access         permission:delete-courses
    */
    public function deleteCourses(Course $course){
        $course->delete();

        return redirect()->route('courses')->with('success', 'Course deleted');
    }
}
