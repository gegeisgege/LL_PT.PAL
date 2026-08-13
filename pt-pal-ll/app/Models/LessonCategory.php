<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCategory extends Model
{
    protected $fillable = ['name'];
    
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'category_id');
    }
}
