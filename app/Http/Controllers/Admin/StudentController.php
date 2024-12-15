<?php
namespace App\Http\Controllers\Admin;

use App\Events\StudentEnrolled;
use App\Events\StudentRemoved;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\Student;
use App\Models\Tag;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // $query = Student::query();
        $query = Student::with('tags'); // Include tags relationship

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $students = $query->limit(10)->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phoneNumber' => 'required|string|max:15',
            'tags' => 'array',
        ]);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phoneNumber = $request->phoneNumber;
        $student->password = bcrypt('121212');
        $student->save();

        $this->syncTags($student, $request->tags);

        return response()->json($student->load('tags'), 201);
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student->load('tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phoneNumber' => 'required|string|max:15',
            'tags' => 'array',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->only(['name', 'email', 'phoneNumber']));

        $this->syncTags($student, $request->tags);

        return response()->json($student->load('tags'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(null, 204);
    }

    public function suspend($id)
    {
        $student = Student::findOrFail($id);
        $student->update(['is_suspended' => true]);

        return response()->json(['message' => 'Student suspended successfully']);
    }

    public function unsuspend($id)
    {
        $student = Student::findOrFail($id);
        $student->update(['is_suspended' => false]);

        return response()->json(['message' => 'Student unsuspended successfully']);
    }

    public function loginHistory($id)
    {
        $activities = ActivityLog::where('user_id', $id)
            ->where('action', 'login')
            ->get();

        return response()->json($activities);
    }

    public function activityReport($id)
    {
        $activities = ActivityLog::where('user_id', $id)
            ->get();

        return response()->json($activities);
    }

    public function purchaseHistory($id)
    {
        $student = Student::findOrFail($id);
        $purchaseHistory = $student->purchaseHistory; // Assuming a relationship is defined
        return response()->json($purchaseHistory);
    }
    public function courses(Student $student)
    {

        $purchaseHistory = $student->courses; // Assuming a relationship is defined
        return response()->json($purchaseHistory);
    }

    public function enroll(Request $request, Student $student)
    {
        $courseId = $request->input('course_id');
        $course = Course::find($courseId);

        if ($course) {
            // Check if the student is already enrolled in the course
            if ($student->courses()->where('course_id', $courseId)->exists()) {
                return response()->json(['message' => 'Student is already enrolled in this course'], 400);
            }

            $student->courses()->attach($courseId, ['enrolled_by' => auth()->id()]);

            event(new StudentEnrolled($student, $course, $student->id));

            event(new StudentEnrolled($student, $course, auth()->id()));

            return response()->json(['message' => 'Enrolled successfully'], 200);
        } else {
            return response()->json(['message' => 'Course not found'], 404);
        }
    }

    public function removeFromCourse(Request $request, Student $student)
    {

    
        $course_id = $request->input('course_id');
     
        $student->courses()->detach($course_id);

      event(new StudentRemoved($student, $course_id, $student->id ));
         event(new StudentRemoved($student, $course_id, auth()->id()));

        return response()->json(['message' => 'Removed from course successfully'], 200);
    }

    public function getStudentCourses(Student $student)
    {

        $courses = DB::table('course_user')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->where('course_user.student_id', $student->id)
            ->select('courses.id as course_id', 'courses.title as course_title')
            ->get();

        return response()->json($courses);
    }

    public function courses2()
    {
        $user = Auth::user();
        $courses = $user->courses; // Assuming you have a relationship defined in the User model
        return response()->json($courses);
    }

    public function fetchBadges(Student $student)
    {

// Assuming there's a relationship defined in the Student model
        $badges = $student->badges;

// Return the badges as a JSON response
        return response()->json($badges);
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        foreach ($data as $row) {
            $studentData = array_combine($header, $row);
            Student::create($studentData);
        }

        return response()->json(['message' => 'Students imported successfully'], 200);
    }
    public function importJson(Request $request)
    {
        $data = $request->json()->all();
        $mandatoryFields = ['name', 'email']; // Add other mandatory fields here
        $newStudents = []; // Array to store new students' emails

        foreach ($data as $row) {
            // Check for mandatory fields
            foreach ($mandatoryFields as $field) {
                if (!isset($row[$field])) {
                    return response()->json(['message' => "Missing mandatory field: $field"], 400);
                }
            }

            // Check if student already exists
            $existingStudent = Student::where('email', $row['email'])->first();
            if (!$existingStudent) {
                $row['password'] = "121212";
                Student::create($row);
                $newStudents[] = $row['email']; // Add new student's email to the array
            }
        }

        // Return the total number of new students and their emails
        return response()->json([
            'message' => 'Students imported successfully',
            'total_new_students' => count($newStudents),
            'new_students_emails' => $newStudents,
        ], 200);
    }

    public function getFilteredStudents(Request $request)
    {
        $selectedColumns = $request->input('columns', []);
        if (empty($selectedColumns)) {
            return response()->json(['message' => 'No columns selected'], 400);
        }

        $students = Student::select($selectedColumns)->get();
        return response()->json($students);
    }

    public function getStudentImportfields()
    {

        $tableColumns = [
            ['value' => 'name', 'text' => 'Name'],
            ['value' => 'email', 'text' => 'Email'],
            ['value' => 'phoneNumber', 'text' => 'phoneNumber'],
            ['value' => 'address', 'text' => 'Address'],
            ['value' => 'city', 'text' => 'City'],
            ['value' => 'state', 'text' => 'State'],
            ['value' => 'pin', 'text' => 'Pin'],
            ['value' => 'education', 'text' => 'Education'],
        ];

        $tableFields = [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'phoneNumber', 'label' => 'phoneNumber'],
            ['key' => 'address', 'label' => 'Address'],
            ['key' => 'city', 'label' => 'City'],
            ['key' => 'state', 'label' => 'State'],
            ['key' => 'pin', 'label' => 'Pin'],
            ['key' => 'education', 'label' => 'Education'],
        ];

        return [$tableColumns, $tableFields];
    }

    public function notifyAllStudents(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = $request->input('message');

        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            $student->notify(new UserNotification($message));
        }

        return response()->json(['message' => 'Notifications sent successfully'], 200);
    }

    private function syncTags(Student $student, $tags)
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags); // Convert comma-separated string to array
        }

        if ($tags) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]); // Trim whitespace
                $tagIds[] = $tag->id;
            }
            $student->tags()->sync($tagIds);
        }
    }

}
