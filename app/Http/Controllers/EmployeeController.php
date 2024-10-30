<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('projects')->get();
        return response()->json($employees);
    }

    public function assignProject(Request $request, Employee $employee, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'role' =>'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($employee->projects()->where('project_id', $project->id)->exists()) {
            return response()->json(['message' => 'Project is already assigned to this employee.'], 409);
        }

        $employee->projects()->attach($project, ['role' => $request->role]);

        return response()->json(['message' => 'Project assigned successfully.'], 200);
    }
}
