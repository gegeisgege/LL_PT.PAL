<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;

class Show extends Component
{

    #[Computed]
    public function relatedLessons()
    {
        $tagIds = $this->lesson->tags->pluck('id');

        return Lesson::where('id', '!=', $this->lesson->id)
            ->where('status', 'published')
            ->where(function ($query) use ($tagIds) {
                $query->where('category_id', $this->lesson->category_id)
                    ->orWhereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds));
            })
            ->withCount(['tags as matching_tags_count' => function ($query) use ($tagIds) {
                $query->whereIn('tags.id', $tagIds);
            }])
            ->with(['project', 'category'])
            ->orderByRaw('(category_id = ?) DESC', [$this->lesson->category_id])
            ->orderByDesc('matching_tags_count')
            ->take(5)
            ->get();
    }

    use WithFileUploads;

    public Lesson $lesson;
    public $newAttachment;

    public function mount(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        // Don't count the author's own views
        if (auth()->id() !== $lesson->author_id) {
            $lesson->increment('views_count');
        }

        $this->lesson = $lesson->load(['project', 'category', 'author', 'tags', 'attachments', 'comments.user']);
    }

    public $newComment = '';

public function addComment()
{
    $this->validate([
        'newComment' => 'required|string|max:2000',
    ]);

    $this->lesson->comments()->create([
        'user_id' => auth()->id(),
        'body' => $this->newComment,
    ]);

    $this->newComment = '';
    $this->lesson->refresh()->load('comments.user');
}

    public function deleteComment($commentId)
    {
        $comment = $this->lesson->comments()->findOrFail($commentId);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();
        $this->lesson->refresh()->load('comments.user');
    }

        public function toggleBookmark()
    {
        $user = auth()->user();

        if ($user->bookmarks()->where('lesson_id', $this->lesson->id)->exists()) {
            $user->bookmarks()->detach($this->lesson->id);
        } else {
            $user->bookmarks()->attach($this->lesson->id);
        }
    }

    public function uploadAttachment()
    {
        $this->authorize('update', $this->lesson);

        $this->validate([
            'newAttachment' => 'required|file|mimes:pdf,docx,xlsx,png,jpg,jpeg|max:10240',
        ]);

        $storedPath = $this->newAttachment->store('lessons/' . $this->lesson->id, 'local');

        $this->lesson->attachments()->create([
            'uploaded_by' => auth()->id(),
            'original_filename' => $this->newAttachment->getClientOriginalName(),
            'stored_filename' => basename($storedPath),
            'storage_path' => $storedPath,
            'mime_type' => $this->newAttachment->getMimeType(),
            'file_size' => $this->newAttachment->getSize(),
        ]);

        $this->newAttachment = null;
        $this->lesson->refresh()->load('attachments');

        session()->flash('message', 'Attachment uploaded.');
    }

    public function render()
    {
        return view('livewire.lessons.show');
    }

    public function approve()
    {
        $this->authorize('approve', $this->lesson);

        $this->lesson->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        session()->flash('message', 'Lesson approved and published.');
    }

    public function return()
    {
        $this->authorize('return', $this->lesson);

        $this->lesson->update(['status' => 'returned']);

        session()->flash('message', 'Lesson returned to author.');
    }
}