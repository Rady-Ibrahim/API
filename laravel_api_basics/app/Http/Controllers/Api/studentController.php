<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' ,
            'gender' => 'required|in:male,female,other'
        ]);
        $student = Student::create($data);
    
        return response()->json($student, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        return response()->json([
            'student' => $student,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student)
    {
        //$data = $request->validate([..............
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:students,email,' . $student->email,
            'gender' => 'sometimes|required|in:male,female,other'
        ]);
        // $student->update($data);
        $student->update($request->all());
        return response()->json([
            'student' => $student,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $student)
    {
        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully',
        ], 204);
    }
}
