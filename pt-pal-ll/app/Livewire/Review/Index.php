<?php

namespace App\Livewire\Review;

use App\Models\Lesson;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        if (auth()->user()->role !== 'reviewer') {
            abort(403);
        }
    }

    public function render()
    {
        $lessons = Lesson::where('status', 'submitted')
            ->with(['project', 'category', 'author'])
            ->oldest()
            ->paginate(10);

        return view('livewire.review.index', [
            'lessons' => $lessons,
        ]);
    }
}