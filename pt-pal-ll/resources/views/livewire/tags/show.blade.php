<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Tag</div>
        <h1 class="text-2xl font-semibold text-ink">{{ $tag->name }}</h1>
    </div>

    <div class="bg-white rounded border border-gray-200 divide-y divide-gray-100">
        @forelse ($lessons as $lesson)
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <a href="{{ route('lessons.show', $lesson) }}" class="font-medium text-ink hover:underline">
                        {{ $lesson->title }}
                    </a>
                    <div class="text-sm text-steel mt-0.5 truncate">
                        {{ $lesson->project->name }} · {{ $lesson->category->name }} · by {{ $lesson->author->name }}
                    </div>
                </div>
                <x-status-badge :status="$lesson->status" class="shrink-0" />
            </div>
        @empty
            <div class="p-6 text-sm text-steel">No lessons with this tag yet.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $lessons->links() }}
    </div>
</div>