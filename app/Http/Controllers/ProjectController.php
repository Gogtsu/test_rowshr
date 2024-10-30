<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('employees')->get();

        return response()->json($projects);
    }

    public function indexOptimized()
    {
        $projects = Cache::remember('projects', 60, function () {
            return Project::paginate(10);
        });
    
        return response()->json($projects);
    }

    public function listContainingRole($role)
    {
        $projects = Project::whereHas('employees', function ($query) use ($role) {
            $query->where('role', $role);
        })->with('employees')->get();

        return response()->json($projects);
    }

    public function listContainingRoleOptimized($role)
    {
        $cacheKey = "projects_role_{$role}";

        $projects = Cache::get($cacheKey);

        if (!$projects) {
            $projects = Project::whereHas('employees', function ($query) use ($role) {
                $query->where('role', $role);
            })->with('employees')->paginate(10); 

            // Only cache if there are results
            if ($projects->total() > 0) {
                Cache::put($cacheKey, $projects, 60);
            }
        }
        return response()->json($projects);
    }

    public function removeEmployee(Project $project, Employee $employee)
    {
        if ($project->employees()->detach($employee->id)) {
            return response()->json(['message' => 'Employee removed from project successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to remove employee from project.'], 500);
    }

    public function fetchCountRoles(Project $project)
    {
        $roles = $project->countEmployeesByRole();

        return response()->json($roles);
    }

    public function changeRole(Request $request, Project $project, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if (!$employee->projects()->where('project_id', $project->id)->exists()) {
            return response()->json(['message' => 'This employee is not assigned to this project.'], 404);
        }

        $employee->projects()->updateExistingPivot($project->id, ['role' => $request->role]);

        return response()->json(['message' => 'Role updated successfully.'], 200);
    }
}
