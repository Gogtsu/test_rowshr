<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }

    public function getProjectsWithRoles()
    {
        return $this->projects->map(function ($project) {
            $project->role = $project->pivot->role; // Attach the pivot role to the project
            return $project;
        });
    }
}
