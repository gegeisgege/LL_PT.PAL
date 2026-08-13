<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use Livewire\Component;

class Departments extends Component
{
    public $name = '';
    public $code = '';

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code',
        ]);

        Department::create(['name' => $this->name, 'code' => $this->code]);

        $this->reset(['name', 'code']);
    }

    public function delete($id)
    {
        Department::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.departments', [
            'departments' => Department::withCount('projects')->get(),
        ]);
    }
}