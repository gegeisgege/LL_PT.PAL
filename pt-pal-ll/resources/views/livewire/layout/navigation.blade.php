<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-ink text-white sm:w-60 sm:shrink-0 sm:flex sm:flex-col sm:sticky sm:top-0 sm:h-screen">    <!-- Top row: logo + mobile hamburger -->
    <div class="flex items-center justify-between px-4 py-4 sm:px-5">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
            <span class="bg-white rounded p-1.5">
            <img src="{{ asset('images/PT-PAL.svg.webp') }}" alt="PT PAL" class="h-6 w-auto">            </span>
            <span class="font-semibold tracking-tight text-white">Lessons Learned</span>
        </a>

        <button @click="open = ! open" class="sm:hidden text-white">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Nav links -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:block sm:flex-1">
        <div class="px-2 space-y-1">
            <a href="{{ route('dashboard') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('lessons.index') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('lessons.index') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                Lessons
            </a>
            <a href="{{ route('lessons.create') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('lessons.create') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                New Lesson
            </a>

            <a href="{{ route('lessons.mine') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('lessons.mine') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                My Contributions
            </a>
        </div>

        <!-- User / logout -->
        <div class="mt-6 px-2 pt-4 border-t border-white/10 sm:mt-auto sm:mb-4">
            <a href="{{ route('profile') }}" wire:navigate class="block px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white">
                {{ auth()->user()->name }}
            </a>
            
        <!-- User / logout -->
            <a href="{{ route('bookmarks.index') }}" wire:navigate
            class="block px-3 py-2 rounded text-sm {{ request()->routeIs('bookmarks.index') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
            Bookmarks
            </a>

            @if (auth()->user()->role === 'reviewer')
                <a href="{{ route('review.index') }}" wire:navigate
                    class="block px-3 py-2 rounded text-sm {{ request()->routeIs('review.index') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    Review Queue
                </a>
            @endif

            @if (auth()->user()->role === 'admin')
                <div class="mt-4 pt-4 border-t border-white/10">
                    <div class="px-3 text-xs font-mono uppercase tracking-widest text-white/40 mb-1">Admin</div>
                    <a href="{{ route('admin.departments') }}" wire:navigate
                        class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.departments') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                        Departments
                    </a>
                </div>
            @endif

            <a href="{{ route('admin.projects') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.projects') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                Projects
            </a>

            <a href="{{ route('admin.categories') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.categories') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                Categories
            </a>
            <a href="{{ route('admin.tags') }}" wire:navigate
                class="block px-3 py-2 rounded text-sm {{ request()->routeIs('admin.tags') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                Tags
            </a>

            <button wire:click="logout" class="w-full text-left px-3 py-2 rounded text-sm text-white/70 hover:bg-white/5 hover:text-white">
                Log Out
            </button>
        </div>
    </div>
</nav>