<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function pageAssignment(){
        $assignment = Assignment::paginate(10);

        return view('assignment.index', [
            'data' => $assignment
        ]);
    }

    public function pageCreateAssignment(){
        $courses = Course::all();

        return view('assignment.create', [
            'courses' => $courses
        ]);
    }
    /*
    @route      POST /assignments
    @desc       Create assignments
    @access     permission:create-assignment
    */
    public function createAssignment(Request $request){
        try {
            $request->validate([
                'course_id' => ['required'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'deadline' => ['required', 'string']
            ]);
            // Check courses
            $course = Course::find($request->course_id);
            if(!$course){
                return response()->json([
                    'success' => false,
                    'msg' => 'Course not found',
                    'error' => 'Course does not exists'
                ], 404);
            }

            // Create
            $data = Assignment::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'description' => $request->description,
                'deadline' => Carbon::parse($request->deadline)->toDateTimeString()
            ]);

            return redirect()->route('assignments')->with('success', 'Assignment created');
        } catch (Exception $error) {
            return redirect()->route('assignments')->with('error', $error->getMessage());
        }
    }
}
