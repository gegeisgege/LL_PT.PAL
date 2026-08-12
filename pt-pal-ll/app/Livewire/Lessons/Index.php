<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use App\Models\Department;
use App\Models\LessonCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $department_id = '';
    public $category_id = '';
    public $sortBy = 'latest';

    public function updating($property)
    {
        if (in_array($property, ['search', 'status', 'department_id', 'category_id', 'sortBy'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $lessons = Lesson::with(['project', 'category', 'author', 'department'])
            ->withCount('bookmarkedBy')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('problem', 'like', '%' . $this->search . '%')
                        ->orWhere('solution', 'like', '%' . $this->search . '%')
                        ->orWhere('root_cause', 'like', '%' . $this->search . '%')
                        ->orWhere('recommendation', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->department_id, fn($query) => $query->where('department_id', $this->department_id))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id))
            ->when($this->sortBy === 'latest', fn($query) => $query->latest())
            ->when($this->sortBy === 'most_viewed', fn($query) => $query->orderByDesc('views_count'))
            ->when($this->sortBy === 'most_bookmarked', fn($query) => $query->orderByDesc('bookmarked_by_count'))
            ->paginate(10);

        return view('livewire.lessons.index', [
            'lessons' => $lessons,
            'departments' => Department::all(),
            'categories' => LessonCategory::all(),
        ]);
    }
}