<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Posts\Index as PostsIndex;

Route::prefix('manage')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', Dashboard::class)->name('manage');
    Route::get('/posts', PostsIndex::class)->name('admin.posts');
});
