<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use App\Models\Project;
use App\Models\LessonCategory;
use App\Models\Tag;
use Livewire\Component;
use App\Models\AuditLog;

class Create extends Component
{
    public $project_id = '';
    public $category_id = '';
    public $title = '';
    public $problem = '';
    public $impact = '';
    public $root_cause = '';
    public $solution = '';
    public $recommendation = '';
    public $severity = 'low';
    public $project_phase = '';
    public $selectedTags = [];

    protected function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'category_id' => 'required|exists:lesson_categories,id',
            'title' => 'required|string|max:255',
            'problem' => 'required|string',
            'impact' => 'nullable|string',
            'root_cause' => 'nullable|string',
            'solution' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'severity' => 'required|in:low,medium,high',
            'project_phase' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        $project = Project::findOrFail($this->project_id);

        $lesson = Lesson::create([
            'project_id' => $project->id,
            'department_id' => $project->department_id,
            'author_id' => auth()->id(),
            'category_id' => $this->category_id,
            'title' => $this->title,
            'problem' => $this->problem,
            'impact' => $this->impact,
            'root_cause' => $this->root_cause,
            'solution' => $this->solution,
            'recommendation' => $this->recommendation,
            'severity' => $this->severity,
            'project_phase' => $this->project_phase,
            'status' => 'draft',
            'visibility' => 'internal',
        ]);

        $lesson->tags()->sync($this->selectedTags);

        AuditLog::record('LESSON_CREATED', $lesson);

        session()->flash('message', 'Lesson saved as draft.');

        return redirect()->route('lessons.index');
    }

    public function render()
    {
        return view('livewire.lessons.create', [
            'projects' => Project::all(),
            'categories' => LessonCategory::all(),
            'tags' => Tag::all(),
        ]);
    }
}