<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\Project;
use App\Models\Department;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalLessons' => Lesson::count(),
            'publishedLessons' => Lesson::where('status', 'published')->count(),
            'totalProjects' => Project::count(),
            'totalContributors' => User::whereHas('lessons')->count(),
            'totalDepartments' => Department::count(),
            'recentLessons' => Lesson::where('status', 'published')
                ->latest('published_at')
                ->take(5)
                ->get(),
            'pendingReview' => Lesson::where('status', 'submitted')->count(),
        ]);
    }
}