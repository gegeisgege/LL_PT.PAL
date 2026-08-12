<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'project_id', 'department_id', 'author_id', 'category_id',
        'title', 'problem', 'impact', 'root_cause', 'solution', 'recommendation',
        'severity', 'project_phase', 'status', 'visibility', 'published_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(LessonCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lesson_tag');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

        public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

        public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    
}
