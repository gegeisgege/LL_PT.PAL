<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_tag');
    }
}
