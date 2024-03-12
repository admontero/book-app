<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('roles', App\Http\Controllers\RoleController::class)
        ->except(['create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('permissions', App\Http\Controllers\PermissionController::class)
        ->except(['create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::get('users/{user}/roles/assignment', App\Livewire\UserRoleAssignmentLive::class)
        ->name('users.roles.assignment');

    Route::get('users/{user}/permissions/assignment', App\Livewire\UserPermissionAssignmentLive::class)
        ->name('users.permissions.assignment');

    Route::get('roles/{role}/permissions/assignment', App\Livewire\RolePermissionAssignmentLive::class)
        ->name('roles.permissions.assignment');

    Route::resource('genres', App\Http\Controllers\GenreController::class);

    Route::get('authors', [App\Http\Controllers\AuthorController::class, 'index'])
        ->name('authors.index');

    Route::get('authors/create', App\Livewire\AuthorCreateLive::class)
        ->name('authors.create');

    Route::get('authors/{author}', App\Livewire\AuthorShowLive::class)
        ->name('authors.show');

    Route::get('authors/{author}/edit', App\Livewire\AuthorEditLive::class)
        ->name('authors.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});
