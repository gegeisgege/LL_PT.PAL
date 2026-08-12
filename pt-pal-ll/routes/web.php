<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use App\Livewire\Dashboard as DashboardPage;

Route::get('dashboard', DashboardPage::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


/**
* Lessons/Create
*/

use App\Livewire\Lessons\Create as LessonCreate;

Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/create', LessonCreate::class)->name('lessons.create');
});

/**
* Lessons/Index
*/

use App\Livewire\Lessons\Index as LessonIndex;

Route::middleware(['auth'])->group(function () {
    Route::get('/lessons', LessonIndex::class)->name('lessons.index');
    Route::get('/lessons/create', LessonCreate::class)->name('lessons.create');
});

/**
* Lessons/Show
*/

use App\Livewire\Lessons\Show as LessonShow;

Route::get('/lessons/{lesson}', LessonShow::class)->name('lessons.show');

/**
* Lessons/Edit
*/

use App\Livewire\Lessons\Edit as LessonEdit;

Route::get('/lessons/{lesson}/edit', LessonEdit::class)->name('lessons.edit');

/**
* HTTP/AttachmentController
*/

use App\Http\Controllers\AttachmentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');
});

/**
* Bookmark
*/

use App\Livewire\Bookmarks\Index as BookmarksIndex;

Route::middleware(['auth'])->group(function () {
    Route::get('/bookmarks', BookmarksIndex::class)->name('bookmarks.index');
});

/**
* TagShow
*/

use App\Livewire\Tags\Show as TagShow;

Route::middleware(['auth'])->group(function () {
    Route::get('/tags/{tag}', TagShow::class)->name('tags.show');
});
