<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('role');
    }
}
