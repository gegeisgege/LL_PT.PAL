<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Knowledge Base</div>
        <h1 class="text-2xl font-semibold text-ink">New Lesson</h1>
    </div>

    <form wire:submit="save" class="bg-white rounded border border-gray-200 p-6 space-y-5">
        <div>
            <label class="block text-sm font-medium text-ink mb-1">Title</label>
            <input type="text" wire:model="title" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            @error('title') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink mb-1">Project</label>
                <select wire:model="project_id" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
                    <option value="">Select project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Category</label>
                <select wire:model="category_id" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="border-t border-gray-100 pt-5 space-y-5">
            <div>
                <label class="block text-sm font-medium text-ink mb-1">Problem</label>
                <textarea wire:model="problem" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink" rows="3"></textarea>
                @error('problem') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Impact</label>
                <textarea wire:model="impact" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink" rows="2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Root Cause</label>
                <textarea wire:model="root_cause" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink" rows="2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Solution</label>
                <textarea wire:model="solution" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink" rows="2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Recommendation</label>
                <textarea wire:model="recommendation" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink" rows="2"></textarea>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-5 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-ink mb-1">Severity</label>
                <select wire:model="severity" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1">Project Phase</label>
                <input type="text" wire:model="project_phase" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-ink mb-1">Tags</label>
            <select wire:model="selectedTags" multiple class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="border-t border-gray-100 pt-5">
            <button type="submit" class="bg-ink text-white text-sm px-4 py-2 rounded hover:bg-ink/90">
                Save Draft
            </button>
        </div>
    </form>
</div>