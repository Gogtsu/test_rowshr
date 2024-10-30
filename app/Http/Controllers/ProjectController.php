<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('employees')->get();

        return response()->json($projects);
    }

    public function listContainingRole($role)
    {
        $projects = Project::whereHas('employees', function ($query) use ($role) {
            $query->where('role', $role);
        })->with('employees')->get();

        return response()->json($projects);
    }
}
