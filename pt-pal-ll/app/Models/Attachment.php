<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'lesson_id', 'uploaded_by', 'original_filename', 'stored_filename',
        'storage_path', 'mime_type', 'file_size',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
