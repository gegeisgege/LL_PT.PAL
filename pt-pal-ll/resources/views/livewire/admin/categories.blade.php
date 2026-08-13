<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <div class="text-xs font-mono uppercase tracking-widest text-steel mb-1">Admin</div>
        <h1 class="text-2xl font-semibold text-ink">Categories</h1>
    </div>

    <form wire:submit="create" class="bg-white rounded border border-gray-200 p-4 mb-6 flex gap-3 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-ink mb-1">Name</label>
            <input type="text" wire:model="name" class="w-full border border-gray-300 rounded p-2 text-sm focus:border-ink focus:ring-ink">
            @error('name') <span class="text-signal-rust text-xs">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-ink text-white text-sm px-4 py-2 rounded hover:bg-ink/90">Add</button>
    </form>

    <div class="bg-white rounded border border-gray-200 divide-y divide-gray-100">
        @foreach ($categories as $category)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-ink">{{ $category->name }}</div>
                    <div class="text-sm text-steel">{{ $category->lessons_count }} lesson{{ $category->lessons_count === 1 ? '' : 's' }}</div>
                </div>
                <button wire:click="delete({{ $category->id }})" wire:confirm="Delete this category? This cannot be undone." class="text-sm text-signal-rust hover:underline">
                    Delete
                </button>
            </div>
        @endforeach
    </div>
</div>