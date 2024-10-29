<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function employees() 
    {
        return $this->belongsToMany(Employee::class)->withPivot('role');
    }

    public function getEmployeesWithRoles()
    {
        return $this->employees->map(function ($employee) {
            $employee->role = $employee->pivot->role; // Attach the pivot role to the employee
            return $employee;
        });
    }

    public function countEmployeesByRole()
    {
        return $this->employees()
            ->select('role', \DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
    }
}
