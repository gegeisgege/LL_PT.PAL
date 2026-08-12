<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Knowledge Hub</div>
        <h1 class="text-2xl font-semibold text-ink">Dashboard</h1>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded border border-gray-200 border-l-4 border-l-ink p-4">
            <div class="text-3xl font-mono font-semibold text-ink">{{ $totalLessons }}</div>
            <div class="text-sm text-steel mt-1">Lessons</div>
        </div>
        <div class="bg-white rounded border border-gray-200 border-l-4 border-l-ink p-4">
            <div class="text-3xl font-mono font-semibold text-ink">{{ $totalProjects }}</div>
            <div class="text-sm text-steel mt-1">Projects</div>
        </div>
        <div class="bg-white rounded border border-gray-200 border-l-4 border-l-ink p-4">
            <div class="text-3xl font-mono font-semibold text-ink">{{ $totalContributors }}</div>
            <div class="text-sm text-steel mt-1">Contributors</div>
        </div>
        <div class="bg-white rounded border border-gray-200 border-l-4 border-l-ink p-4">
            <div class="text-3xl font-mono font-semibold text-ink">{{ $totalDepartments }}</div>
            <div class="text-sm text-steel mt-1">Departments</div>
        </div>
    </div>

    @if ($pendingReview > 0)
        <div class="mb-6 flex items-center gap-2 px-4 py-3 rounded border border-signal-amber/40 bg-signal-amber/10 text-sm text-ink">
            <span class="font-mono text-signal-amber font-semibold">{{ $pendingReview }}</span>
            lesson{{ $pendingReview > 1 ? 's' : '' }} awaiting review.
        </div>
    @endif

    <div class="bg-white rounded border border-gray-200">
        <div class="px-4 py-3 border-b border-gray-200 text-sm font-medium text-ink">Recently Published</div>
        @forelse ($recentLessons as $lesson)
            <div class="px-4 py-3 border-b border-gray-100 last:border-0 flex items-center justify-between">
                <a href="{{ route('lessons.show', $lesson) }}" class="text-sm text-ink hover:underline">{{ $lesson->title }}</a>
                <x-status-badge :status="$lesson->status" />
            </div>
        @empty
            <p class="px-4 py-6 text-sm text-steel">No published lessons yet.</p>
        @endforelse
    </div>
</div>