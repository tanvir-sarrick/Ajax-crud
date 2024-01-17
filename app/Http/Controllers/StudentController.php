<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(){
        return view('index');
    }

    public function getTableData(){
        $students = Student::orderBy('name', 'asc')->get();

        return response()->json(['data' => $students]);
    }

    public function store(Request $request){
        // Your validation logic goes here
        $validatedData = $request->validate([
            'name' => 'required',
            'id_card' => 'required',
        ],

        [
            'name.required' => 'The name field is required.',
            'id_card.required' => 'The ID card field is required.',
        ]);

        // Your data saving logic goes here
        try {
            Student::create([
                'name' => $validatedData['name'],
                'id_card' => $validatedData['id_card'],
                // Add more fields as needed
            ]);

            return response()->json(['success' => true, 'message' => 'Data saved successfully']);
        }

        catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving data: ' . $e->getMessage()]);
        }
    }
}
