<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Knowledge Base</div>
            <h1 class="text-2xl font-semibold text-ink">Lessons</h1>
        </div>
        <a href="{{ route('lessons.create') }}" class="bg-ink text-white text-sm px-4 py-2 rounded hover:bg-ink/90">
            + New Lesson
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-4">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search lessons..."
            class="border border-gray-300 rounded p-2 text-sm col-span-2 focus:border-ink focus:ring-ink"
        >

        <select wire:model.live="status" class="border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            <option value="">All statuses</option>
            <option value="draft">Draft</option>
            <option value="submitted">Submitted</option>
            <option value="returned">Returned</option>
            <option value="published">Published</option>
        </select>

        <select wire:model.live="department_id" class="border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            <option value="">All departments</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="sortBy" class="border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            <option value="latest">Newest first</option>
            <option value="most_viewed">Most viewed</option>
            <option value="most_bookmarked">Most bookmarked</option>
        </select>
    </div>

    @if (session('message'))
        <div class="mb-4 px-4 py-3 rounded border border-signal-teal/40 bg-signal-teal/10 text-sm text-ink">
            {{ session('message') }}
        </div>
    @endif

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
            <div class="p-6 text-sm text-steel">No lessons yet.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $lessons->links() }}
    </div>
</div>