<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;

class Show extends Component
{
    public Tag $tag;

    public function mount(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render()
    {
        $lessons = $this->tag->lessons()
            ->with(['project', 'category', 'author'])
            ->latest()
            ->paginate(10);

        return view('livewire.tags.show', [
            'lessons' => $lessons,
        ]);
    }
}