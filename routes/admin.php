<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;

Route::prefix('manage')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', Dashboard::class)->name('manage');
});
