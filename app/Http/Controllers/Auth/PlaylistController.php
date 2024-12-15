<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


use App\Models\Playlist;
use App\Models\Video;
use App\Models\StudyMaterial;
use Illuminate\Http\Request;


use App\Models\Course;

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

    
    public function getPlaylistVideos(Course $course)
    {
    $playlists = Playlist::where('course_id', $course->id)
    ->with('videos') // Assuming you have a relationship defined in the Playlist model
    ->get();


    return response()->json([
        'course' => $course,
        'playlists' => $playlists
        ]);

        
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