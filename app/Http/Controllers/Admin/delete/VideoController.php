<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);

        $video = Video::create($request->all());

        // Dispatch the video created event
        event(new VideoCreated(auth()->id(), $video->id));

        return response()->json($video, 201);
    }

    public function getLastThreeVideos()
    {
        $videos = Video::orderBy('created_at', 'desc')->take(3)->get();
        return response()->json($videos);
    }

    public function getVideosByCourse($courseId)
    {
        $videos = Video::where('course_id', $courseId)->orderBy('created_at', 'desc')->get();


        
        $videos = Video::all();


        return response()->json($videos);
    }

    public function get_videos()
    {
        $user = Auth::user();
        $videos = Video::where('user_id', $user->id)->get();

        return response()->json($videos);
    }

    public function get_unpublished_videos()
    {
        $user = Auth::user();
        $videos = Video::where('user_id', $user->id)
            ->whereNotNull('course_id') // Ensure the video is attached to a course
            ->get();

        return response()->json($videos);
    }

    public function get_attached_videos()
    {
        $videos = Video::whereNotNull('course_id')->get();
        return response()->json($videos);
    }

    public function get_unattached_videos()
    {
        $videos = Video::whereNull('course_id')->get();
        return response()->json($videos);
    }

    public function post_video(Request $request, $id)
    {

        /*

        SQLSTATE[HY000]: General error: 1 no such column: tags (Connection: sqlite, SQL: update "videos" set "course_id" = 2, "playlist_id" = 2, "description" = fsdfsd, "tags" = fsdfs, "category" = sdfds, "updated_at" = 2024-11-13 09:47:00 where "id" = 2)

         */
        // Validate the request data
        $request->validate([
            'course_id' => 'required|integer',
            'playlist_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|string',

            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the video by ID
        $video = Video::findOrFail($id);

        // Update the video details
        $video->course_id = $request->course_id;
        $video->playlist_id = $request->playlist_id;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->tags = $request->tags;
        //  $video->category = $request->category;

        // Handle the thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $video->thumbnail = $thumbnailPath;
        }

        // Save the updated video
        $video->save();
        return response()->json($video);
        // Redirect to the videos list or any other page
        //  return redirect()->route('videos.index')->with('success', 'Video updated successfully.');
    }
    public function get_video(Video $video)
    {

        return $video;
    }

    public function uploadMultipleVideos(Request $request)
    {

        $user = Auth::user(); // Get the authenticated user
        $date = Carbon::now()->format('Y-m-d'); // Get the current date
        $videos = $request->file('videos');

        $uploadedVideos = [];

        if (is_array($videos)) {
            foreach ($videos as $video) {
                // Create a directory for the user with the current date if it doesn't exist
                $userDirectory = "videos/{$user->id}/{$date}";
                if (!Storage::disk('public')->exists($userDirectory)) {
                    Storage::disk('public')->makeDirectory($userDirectory);
                }

                // Store the video in the user's dated directory
                $path = $video->store($userDirectory, 'public');
                $videoData = [
                    'user_id' => $user->id,
                    'course_id' => $request->input('course_id'),
                    'playlist_id' => $request->input('playlist_id'),
                    'title' => $video->getClientOriginalName(),
                    'description' => $request->input('description'),
                    'path' => $path,
                    'url' => Storage::url($path),
                ];

                // Save the video details to the database
                Video::create($videoData);

                $uploadedVideos[] = $videoData;
            }
        } else {
            return response()->json(['message' => 'No videos uploaded.'], 400);
        }

        return response()->json(['message' => 'Videos uploaded successfully', 'videos' => $uploadedVideos]);
    }

}
