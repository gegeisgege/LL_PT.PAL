<?php

namespace App\Livewire\Admin;

use App\Models\LessonCategory;
use Livewire\Component;

class Categories extends Component
{
    public $name = '';

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:lesson_categories,name',
        ]);

        LessonCategory::create(['name' => $this->name]);

        $this->reset('name');
    }

    public function delete($id)
    {
        LessonCategory::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => LessonCategory::withCount('lessons')->get(),
        ]);
    }
}