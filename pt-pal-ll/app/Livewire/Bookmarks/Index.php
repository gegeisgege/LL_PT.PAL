<?php

namespace App\Livewire\Bookmarks;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $lessons = auth()->user()->bookmarks()
            ->with(['project', 'category', 'author'])
            ->latest('bookmarks.created_at')
            ->paginate(10);

        return view('livewire.bookmarks.index', [
            'lessons' => $lessons,
        ]);
    }
}