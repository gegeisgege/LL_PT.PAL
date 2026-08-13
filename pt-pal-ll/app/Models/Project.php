<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'code', 'department_id', 'description'];
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
