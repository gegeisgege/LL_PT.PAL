<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use App\Models\Project;
use App\Models\LessonCategory;
use App\Models\Tag;
use Livewire\Component;
use App\Models\AuditLog;

class Edit extends Component
{
    public Lesson $lesson;

    public $project_id;
    public $category_id;
    public $title;
    public $problem;
    public $impact;
    public $root_cause;
    public $solution;
    public $recommendation;
    public $severity;
    public $project_phase;
    public $selectedTags = [];

    public function mount(Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        $this->lesson = $lesson;
        $this->project_id = $lesson->project_id;
        $this->category_id = $lesson->category_id;
        $this->title = $lesson->title;
        $this->problem = $lesson->problem;
        $this->impact = $lesson->impact;
        $this->root_cause = $lesson->root_cause;
        $this->solution = $lesson->solution;
        $this->recommendation = $lesson->recommendation;
        $this->severity = $lesson->severity;
        $this->project_phase = $lesson->project_phase;
        $this->selectedTags = $lesson->tags->pluck('id')->toArray();
    }

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
        $this->authorize('update', $this->lesson);
        $this->validate();

        $project = Project::findOrFail($this->project_id);

        $this->lesson->tags()->sync($this->selectedTags);

        AuditLog::record('LESSON_UPDATED', $this->lesson);
        session()->flash('message', 'Lesson updated.');

        $this->lesson->update([
            'project_id' => $project->id,
            'department_id' => $project->department_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'problem' => $this->problem,
            'impact' => $this->impact,
            'root_cause' => $this->root_cause,
            'solution' => $this->solution,
            'recommendation' => $this->recommendation,
            'severity' => $this->severity,
            'project_phase' => $this->project_phase,
        ]);

        $this->lesson->tags()->sync($this->selectedTags);

        session()->flash('message', 'Lesson updated.');

        return redirect()->route('lessons.show', $this->lesson);
    }

    public function submit()
    {
        $this->authorize('submit', $this->lesson);

        $this->lesson->update(['status' => 'submitted']);

        AuditLog::record('LESSON_SUBMITTED', $this->lesson);

        session()->flash('message', 'Lesson submitted for review.');

        return redirect()->route('lessons.show', $this->lesson);
    }

    public function render()
    {
        return view('livewire.lessons.edit', [
            'projects' => Project::all(),
            'categories' => LessonCategory::all(),
            'tags' => Tag::all(),
        ]);
    }
}