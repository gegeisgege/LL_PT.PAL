<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson): bool
    {
        return true;
    }

    public function update(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->author_id && in_array($lesson->status, ['draft', 'returned']);
    }

    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->author_id && $lesson->status === 'draft';
    }

    public function submit(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->author_id && in_array($lesson->status, ['draft', 'returned']);
    }

    public function approve(User $user, Lesson $lesson): bool
    {
        return $user->role === 'reviewer' && $lesson->status === 'submitted';
    }

    public function return(User $user, Lesson $lesson): bool
    {
        return $user->role === 'reviewer' && $lesson->status === 'submitted';
    }
}