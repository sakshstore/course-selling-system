<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Playlist;
use App\Models\Video;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the playlists for a specific course.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function index($courseId)
    {
        $playlists = Playlist::where('course_id', $courseId)->with('studyMaterials')->get();
        return response()->json($playlists);
    }

    /**
     * Store a newly created playlist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = Playlist::create([
            'name' => $request->name,
            'course_id' => $courseId,
            'user_id' => $request->user()->id, // Assuming you are using Laravel's authentication
        ]);

        return response()->json($playlist, 201);
    }

    /**
     * Add a study material to a playlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $playlistId
     * @return \Illuminate\Http\Response
     */
    public function addStudyMaterial(Request $request, $playlistId)
    {
        $request->validate([
            'study_material_id' => 'required|exists:study_materials,id',
        ]);

        $playlist = Playlist::findOrFail($playlistId);
        $playlist->studyMaterials()->attach($request->study_material_id);

        return response()->json($playlist->load('studyMaterials'));
    }


    /**
     * Get videos for a specific playlist and course.
     *
     * @param  int  $courseId
     * @param  int  $playlistId
     * @return \Illuminate\Http\Response
     */
    public function getVideos(  $courseId,$playlistId )
    {
    $videos = Video::where('course_id', $courseId)
            ->where('playlist_id', $playlistId)
            ->get();

        return response()->json($videos);
        
    }
}