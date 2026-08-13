<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use Livewire\Component;
use Livewire\WithPagination;

class MyContributions extends Component
{
    use WithPagination;

    public $status = '';

    public function updating($property)
    {
        if ($property === 'status') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $lessons = Lesson::where('author_id', auth()->id())
            ->with(['project', 'category'])
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(10);

        return view('livewire.lessons.my-contributions', [
            'lessons' => $lessons,
        ]);
    }
}