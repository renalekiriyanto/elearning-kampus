<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialsController extends Controller
{
    public function pageMaterials(){
        $materials = Material::paginate(10);

        return view('materials.index', [
            'data' => $materials
        ]);
    }

    public function createMaterial(){
        $courses = Course::all();
        return view('materials.create', [
            'courses' => $courses
        ]);
    }

    /*
    @route      POST /materials
    @desc       Upload materials
    @access     permission:upload-materials
    */
    public function uploadMaterials(Request $request){
        try {
            $request->validate([
                'course_id' => ['required'],
                'title' => ['required', 'string', 'max:255'],
                'file_path' => ['required', 'mimes:pdf', 'max:2048']
            ]);

            // Check course
            $course = Course::find($request->course_id);
            if(!$course){
                return response()->json([
                    'success' =>  true,
                    'msg' => 'Course not found'
                ], 404);
            }

            // Genereate file name
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $location = Storage::putFileAs('materials', $file, $fileName);

            // Create materials
            $material = Material::create([
                'course_id' => $course->id,
                'title' => $request->title,
                'file_path' => $location
            ]);

            return redirect()->route('materials')->with('success', 'Material uploaded');

        } catch (Exception $error) {
            return redirect()->route('materials')->with('error', $error->getMessage());
        }
    }

    /*
    @route      POST /materials
    @desc       Download materials
    @access     permission:download-materials
    */
    public function downloadMaterials(Material $materials){
        try {
            $file_name = str_replace('materials.', '', $materials->file_path);
            $rename = 'file-' . Str::slug($file_name);
            return Storage::download($file_name, $rename);
        } catch (Exception $error) {
            return redirect()->back()->with('error', $error->getMessage());
        }
    }
}
