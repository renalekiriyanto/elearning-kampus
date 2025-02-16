<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    /*
    @route      POST /api/submissions
    @desc       Create submission
    @access     permission:upload-submissions
    */
    public function createSubmission(Request $request){
        try {
            $request->validate([
                'assignment_id' => ['required'],
                'file_path' => ['required', 'mimes:pdf', 'max:2048']
            ]);

            // Check assignment
            $assignment = Assignment::find($request->assignment_id);
            if(!$assignment){
                return response()->json([
                    'success' =>  true,
                    'msg' => 'Assignment not found'
                ], 404);
            }

            // Genereate file name
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $location = Storage::putFileAs('submissions/', $file, $fileName);

            // Create submission
            $submission = Submission::create([
                'assignment_id' => $assignment->id,
                'student_id' => Auth::user()->id,
                'file_path' => $location
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Submission created',
                'data' => $submission
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
    @route      POST /api/submissions/{id}/grade
    @desc       Grade submission
    @access     permission:rate-submissions
    */
    public function rateSubmission(Request $request, Submission $submission){
        try {
            $request->validate([
                'score' => ['required'],
            ]);

            // Update submission
            $submission->update([
                'score' => $request->score
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Submission updated',
                'data' => $submission
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
