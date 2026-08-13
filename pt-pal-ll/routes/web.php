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

Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/{lesson}', LessonShow::class)->name('lessons.show');
});

/**
* Lessons/Edit
*/

use App\Livewire\Lessons\Edit as LessonEdit;

Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/{lesson}/edit', LessonEdit::class)->name('lessons.edit');
});

/**
* HTTP/AttachmentController
*/

use App\Http\Controllers\AttachmentController;

Route::middleware(['auth', 'throttle:30,1'])->group(function () {
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

/**
* Review/Index
*/

use App\Livewire\Review\Index as ReviewIndex;

Route::middleware(['auth'])->group(function () {
    Route::get('/review', ReviewIndex::class)->name('review.index');
});

/**
* MyContributions
*/

use App\Livewire\Lessons\MyContributions;

Route::middleware(['auth'])->group(function () {
    Route::get('/my-lessons', MyContributions::class)->name('lessons.mine');
});

/**
* Departments
*/

use App\Livewire\Admin\Departments as AdminDepartments;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/departments', AdminDepartments::class)->name('admin.departments');
});

/**
* Projects
*/

use App\Livewire\Admin\Projects as AdminProjects;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/projects', AdminProjects::class)->name('admin.projects');
});

/**
* Tags and categories
*/

use App\Livewire\Admin\Categories as AdminCategories;
use App\Livewire\Admin\Tags as AdminTags;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/categories', AdminCategories::class)->name('admin.categories');
    Route::get('/admin/tags', AdminTags::class)->name('admin.tags');
});