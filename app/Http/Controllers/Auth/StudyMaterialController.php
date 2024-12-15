<?php



namespace App\Http\Controllers;

use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudyMaterialController extends Controller
{
    public function index($courseId)
    {
        return StudyMaterial::where('course_id', $courseId)->get();
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'type' => 'nullable|string',
            'uploaded_by' => 'required|exists:users,id',
            'upload_date' => 'nullable|date',
            'visibility' => 'required|string|in:public,private',
            'tags' => 'nullable|string',
            'order' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|integer',
            'size' => 'nullable|integer'
        ]);

        $studyMaterialData = $request->only([
            'title',
            'description',
            'type',
            'uploaded_by',
            'upload_date',
            'visibility',
            'tags',
            'order',
            'thumbnail',
            'duration',
            'size'
        ]);
        $studyMaterialData['course_id'] = $courseId;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('study_materials');
            $studyMaterialData['file_path'] = $path;
        }

        $studyMaterial = StudyMaterial::create($studyMaterialData);

        return response()->json($studyMaterial, 201);
    }

    public function show($id)
    {
        return StudyMaterial::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'type' => 'nullable|string',
            'uploaded_by' => 'required|exists:users,id',
            'upload_date' => 'nullable|date',
            'visibility' => 'required|string|in:public,private',
            'tags' => 'nullable|string',
            'order' => 'nullable|integer',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|integer',
            'size' => 'nullable|integer'
        ]);

        $studyMaterial = StudyMaterial::findOrFail($id);
        $studyMaterialData = $request->only([
            'title',
            'description',
            'type',
            'uploaded_by',
            'upload_date',
            'visibility',
            'tags',
            'order',
            'thumbnail',
            'duration',
            'size'
        ]);

        if ($request->hasFile('file')) {
            if ($studyMaterial->file_path) {
                Storage::delete($studyMaterial->file_path);
            }
            $path = $request->file('file')->store('study_materials');
            $studyMaterialData['file_path'] = $path;
        }

        $studyMaterial->update($studyMaterialData);

        return response()->json($studyMaterial);
    }

    public function destroy($id)
    {
        $studyMaterial = StudyMaterial::findOrFail($id);
        if ($studyMaterial->file_path) {
            Storage::delete($studyMaterial->file_path);
        }
        $studyMaterial->delete();

        return response()->json(null, 204);
    }
}