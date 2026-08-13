<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Livewire\Component;

class Tags extends Component
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
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        Tag::create(['name' => $this->name]);

        $this->reset('name');
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.tags', [
            'tags' => Tag::withCount('lessons')->get(),
        ]);
    }
}