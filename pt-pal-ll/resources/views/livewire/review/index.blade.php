<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Review</div>
        <h1 class="text-2xl font-semibold text-ink">Review Queue</h1>
    </div>

    <div class="bg-white rounded border border-gray-200 divide-y divide-gray-100">
        @forelse ($lessons as $lesson)
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <a href="{{ route('lessons.show', $lesson) }}" class="font-medium text-ink hover:underline">
                        {{ $lesson->title }}
                    </a>
                    <div class="text-sm text-steel mt-0.5 truncate">
                        {{ $lesson->project->name }} · {{ $lesson->category->name }} · by {{ $lesson->author->name }} · submitted {{ $lesson->updated_at->diffForHumans() }}
                    </div>
                </div>
                <a href="{{ route('lessons.show', $lesson) }}" class="text-sm text-ink font-medium hover:underline shrink-0">
                    Review →
                </a>
            </div>
        @empty
            <div class="p-6 text-sm text-steel">Nothing waiting for review.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $lessons->links() }}
    </div>
</div>