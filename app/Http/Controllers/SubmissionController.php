<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function submission(){
        $data = Submission::paginate(10);

        return view('submission.index', [
            'data' => $data
        ]);
    }

    public function pageCreateSubmission(){
        $assignments = Assignment::all();
        return view('submission.create', [
            'data' => $assignments
        ]);
    }

    /*
    @route      POST /submissions
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

            return redirect()->route('submissions')->with('success', 'Submission completed');

        } catch (Exception $error) {
            return redirect()->route('submissions')->with('error', $error->getMessage());
        }
    }
}
