<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        if($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|digits:5',
            'fullname' => 'required|string|max:191',
            'email' => 'required|email|max:191',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::create([
                'student_id' => $request->student_id,
                'fullname' => $request->fullname,
                'email' => $request->email
            ]);

            if($student) {
                return response()->json([
                    'status' => 200,
                    'message' => "Student Created Successfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!"
                ], 500);
            }
        }
    }

    public function show($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ], 404);
        }
    }

    public function edit($id){
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id) {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|digits:5',
            'fullname' => 'required|string|max:191',
            'email' => 'required|email|max:191',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::find($id);

            if($student) {
                $student->update([
                    'student_id' => $request->student_id,
                    'fullname' => $request->fullname,
                    'email' => $request->email
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Student Updated Successfully"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No Such Student Found!"
                ], 404);
            }
        }
    }

    public function destroy($id) {
        $student = Student::find($id); {
            if($student) {
                $student->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "Student Deleted Successfully!"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No Such Student Found!"
                ], 404);
            }
        }
    }
}
