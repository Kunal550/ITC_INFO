<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('ddd');
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email', 
            'phone' => 'required|numeric|digits_between:10,15',
        ]);

        $existingStudent = Student::where('email', $request->email)->first();

        if ($existingStudent) {
            return response()->json([
                'message' => 'A student with this email already exists.',
            ], 400);
        }

        // Create new student if no duplicate is found
        $student = Student::create($validated);

        // Return success response
        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) return response()->json(['message' => 'Student not found'], 404);
        return response()->json($student, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // var_dump($id,$request->all());
        $student = Student::find($id);
        if (!$student) return response()->json(['message' => 'Student not found'], 404);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:students,email,$id",
            'phone' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student->update($request->all());
        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) return response()->json(['message' => 'Student not found'], 404);

        $student->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
