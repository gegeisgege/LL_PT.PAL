<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-start mb-2">
        <div>
            <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Knowledge Base</div>
            <h1 class="text-2xl font-semibold text-ink">{{ $lesson->title }}</h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('lessons.index') }}" class="text-sm text-steel hover:text-ink">Back to list</a>
            <button wire:click="toggleBookmark" class="text-sm {{ auth()->user()->bookmarks->contains($lesson->id) ? 'text-signal-amber font-medium' : 'text-steel hover:text-ink' }}">
                {{ auth()->user()->bookmarks->contains($lesson->id) ? '★ Bookmarked' : '☆ Bookmark' }}
            </button>
            @if (in_array($lesson->status, ['draft', 'returned']) && auth()->id() === $lesson->author_id)
                <a href="{{ route('lessons.edit', $lesson) }}" class="text-sm text-ink font-medium hover:underline">Edit</a>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-2 text-sm text-steel mb-6">
        <span>{{ $lesson->project->name }} · {{ $lesson->category->name }} · by {{ $lesson->author->name }} · {{ $lesson->views_count }} view{{ $lesson->views_count === 1 ? '' : 's' }}</span>
        <x-status-badge :status="$lesson->status" />
    </div>

    <div class="bg-white rounded border border-gray-200 p-6 space-y-5">
        <div>
            <div class="font-medium text-sm text-steel mb-1">Problem</div>
            <p class="text-ink">{{ $lesson->problem }}</p>
        </div>

        @if ($lesson->impact)
            <div>
                <div class="font-medium text-sm text-steel mb-1">Impact</div>
                <p class="text-ink">{{ $lesson->impact }}</p>
            </div>
        @endif

        @if ($lesson->root_cause)
            <div>
                <div class="font-medium text-sm text-steel mb-1">Root Cause</div>
                <p class="text-ink">{{ $lesson->root_cause }}</p>
            </div>
        @endif

        @if ($lesson->solution)
            <div>
                <div class="font-medium text-sm text-steel mb-1">Solution</div>
                <p class="text-ink">{{ $lesson->solution }}</p>
            </div>
        @endif

        @if ($lesson->recommendation)
            <div>
                <div class="font-medium text-sm text-steel mb-1">Recommendation</div>
                <p class="text-ink">{{ $lesson->recommendation }}</p>
            </div>
        @endif

        @if ($lesson->tags->isNotEmpty())
            <div class="flex gap-2 pt-2">
                @foreach ($lesson->tags as $tag)
                    <a href="{{ route('tags.show', $tag) }}" class="text-xs font-mono bg-gray-100 text-steel px-2 py-1 rounded hover:bg-gray-200">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="border-t border-gray-100 pt-5">
            <div class="font-medium text-sm text-steel mb-2">Attachments</div>

            @forelse ($lesson->attachments as $attachment)
                <div class="flex justify-between items-center py-1.5 text-sm">
                    <span class="text-ink">{{ $attachment->original_filename }}</span>
                    <a href="{{ route('attachments.download', $attachment) }}" class="text-ink font-medium hover:underline">Download</a>
                </div>
            @empty
                <p class="text-sm text-steel">No attachments.</p>
            @endforelse

            @if (in_array($lesson->status, ['draft', 'returned']) && auth()->id() === $lesson->author_id)
                <form wire:submit="uploadAttachment" class="mt-3 flex items-center gap-3">
                    <input type="file" wire:model="newAttachment" class="text-sm">
                    <button type="submit" class="bg-steel text-white px-3 py-1.5 rounded text-sm hover:bg-steel/90">Upload</button>
                </form>
                @error('newAttachment') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
                <div wire:loading wire:target="newAttachment" class="text-sm text-steel mt-1">Uploading...</div>
            @endif
        </div>

        @if ($lesson->status === 'submitted' && auth()->user()->role === 'reviewer')
            <div class="flex gap-3 pt-5 border-t border-gray-100">
                <button wire:click="approve" class="bg-signal-teal text-white text-sm px-4 py-2 rounded hover:bg-signal-teal/90">
                    Approve & Publish
                </button>
                <button wire:click="return" class="bg-signal-rust text-white text-sm px-4 py-2 rounded hover:bg-signal-rust/90">
                    Return to Author
                </button>
            </div>
        @endif
    </div>

    @if ($this->relatedLessons->isNotEmpty())
        <div class="mt-6">
            <div class="text-xs font-mono uppercase tracking-widest text-steel mb-2">Related Lessons</div>
            <div class="bg-white rounded border border-gray-200 divide-y divide-gray-100">
                @foreach ($this->relatedLessons as $related)
                    <a href="{{ route('lessons.show', $related) }}" class="block p-3 hover:bg-gray-50">
                        <div class="text-sm font-medium text-ink">{{ $related->title }}</div>
                        <div class="text-xs text-steel mt-0.5">{{ $related->project->name }} · {{ $related->category->name }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-2">Discussion</div>
        <div class="bg-white rounded border border-gray-200 p-6">
            <form wire:submit="addComment" class="mb-5">
                <textarea wire:model="newComment" rows="2" placeholder="Ask a question or leave a note..."
                    class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink"></textarea>
                @error('newComment') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
                <button type="submit" class="mt-2 bg-ink text-white text-sm px-4 py-1.5 rounded hover:bg-ink/90">
                    Comment
                </button>
            </form>

            <div class="space-y-4">
                @forelse ($lesson->comments as $comment)
                    <div class="flex justify-between items-start border-t border-gray-100 pt-4 first:border-0 first:pt-0">
                        <div>
                            <div class="text-sm">
                                <span class="font-medium text-ink">{{ $comment->user->name }}</span>
                                <span class="text-steel text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-ink mt-1">{{ $comment->body }}</p>
                        </div>
                        @if ($comment->user_id === auth()->id())
                            <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="Delete this comment?" class="text-xs text-signal-rust hover:underline shrink-0">
                                Delete
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-steel">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>