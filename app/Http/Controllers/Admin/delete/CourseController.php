<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Course;
use App\Models\Student;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 

class CourseController extends Controller
{
    public function index()
    {
        return Course::with('studyMaterials')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'category' => 'nullable|string',
            'duration' => 'nullable|integer',
            'level' => 'nullable|string',
            'price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|string|in:draft,published,archived',
        ]);

        $course = Course::create($request->all());

        return response()->json($course, 201);
    }

    public function show($id)
    {
        return Course::with('studyMaterials')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'category' => 'nullable|string',
            'duration' => 'nullable|integer',
            'level' => 'nullable|string',
            'price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|string|in:draft,published,archived',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());

        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(null, 204);
    }
    

    public function getUserCourses()
    {
        $user = Auth::user();

        $student = Student::findOrFail($user->id);


        $courses = $student->courses; // Assuming you have a relationship defined in the User model
        return response()->json($courses);
    }

    public function getRecommendedCourses()
    {
        $user = Auth::user();
// Logic to fetch recommended courses based on user's interests
// This is just a placeholder. Replace it with your actual recommendation logic.
        $recommendedCourses = Course::all();
        return response()->json($recommendedCourses);
    }

    public function purchase(Request $request, Course $course)
    {
        $user = auth()->user();

// Create an invoice
        $invoice = Invoice::create([
            'contact_id' => $user->contact_id, // Assuming the user has a contact_id
            'user_id' => $user->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'order_number' => $this->generateOrderNumber(),
            'invoice_date' => now(),
            'due_date' => now()->addDays(30), // Example due date
            'customer_note' => 'Thank you for your purchase!',
            'terms' => 'Payment due within 30 days.',
            'status' => 'paid',
            'file_path' => null, // Assuming file_path is optional
        ]);

// Attach the course as a product to the invoice
        $invoice->products()->attach($course->id, [
            'quantity' => 1,
            'description' => $course->description,
            'price' => $course->price,
        ]);

        return response()->json(['invoice_id' => $invoice->id]);
    }

    public function getEnrollments()
    {
        $enrollments = DB::table('course_user')
            ->join('users', 'course_user.student_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select('courses.id as course_id', 'courses.title as course_title', 'users.id as student_id', 'users.name as student_name')
            ->get();

        return response()->json($enrollments);
    }

}
