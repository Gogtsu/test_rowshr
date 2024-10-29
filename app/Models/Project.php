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
}
