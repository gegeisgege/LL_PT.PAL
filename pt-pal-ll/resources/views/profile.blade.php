<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded border border-gray-200 p-6 flex items-center justify-between">
            <div>
                <div class="text-lg font-medium text-ink">{{ auth()->user()->name }}</div>
                <div class="text-sm text-steel">{{ auth()->user()->email }}</div>
                <div class="text-sm text-steel mt-1">
                    {{ auth()->user()->department->name ?? 'No department' }}
                </div>
            </div>
            <span class="text-xs font-mono uppercase tracking-wide bg-gray-100 text-steel px-2 py-1 rounded border border-gray-300">
                {{ auth()->user()->role }}
            </span>
        </div>

        <div class="bg-white rounded border border-gray-200 p-6">
            <livewire:profile.update-profile-information-form />
        </div>

        <div class="bg-white rounded border border-gray-200 p-6">
            <livewire:profile.update-password-form />
        </div>

        <div class="bg-white rounded border border-gray-200 p-6">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</x-app-layout>