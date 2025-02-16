<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /*
    @route      POST /api/assignments
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

            return response()->json([
                'success' => true,
                'msg' => 'Assignment created',
                'data' => $data
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
