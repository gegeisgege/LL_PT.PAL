<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use App\Models\Department;
use Livewire\Component;

class Projects extends Component
{
    public $name = '';
    public $code = '';
    public $department_id = '';

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
            'code' => 'required|string|max:20|unique:projects,code',
            'department_id' => 'required|exists:departments,id',
        ]);

        Project::create([
            'name' => $this->name,
            'code' => $this->code,
            'department_id' => $this->department_id,
        ]);

        $this->reset(['name', 'code', 'department_id']);
    }

    public function delete($id)
    {
        Project::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.projects', [
            'projects' => Project::with('department')->withCount('lessons')->get(),
            'departments' => Department::all(),
        ]);
    }
}