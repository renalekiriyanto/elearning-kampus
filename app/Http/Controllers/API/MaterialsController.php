<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class MaterialsController extends Controller
{
    /*
    @route      POST /api/materials
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

            return response()->json([
                'success' => true,
                'msg' => 'Upload material successfully',
                'data' => $material
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
    @route      POST /api/materials
    @desc       Download materials
    @access     permission:download-materials
    */
    public function downloadMaterials(Material $materials){
        try {
            $file_name = str_replace('materials.', '', $materials->file_path);
            $rename = 'file-' . Str::slug($file_name);
            return Storage::download($file_name, $rename);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
