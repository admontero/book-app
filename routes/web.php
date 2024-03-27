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
    Route::get('roles', App\Livewire\Role\ListLive::class)
        ->name('roles.index');

    Route::get('roles/{role}', App\Livewire\Role\ShowLive::class)
        ->name('roles.show');

    Route::get('roles/{role}/permissions/assignment', App\Livewire\Role\PermissionAssignmentLive::class)
        ->name('roles.permissions.assignment');

    Route::get('permissions', App\Livewire\Permission\ListLive::class)
        ->name('permissions.index');

    Route::get('users', App\Livewire\User\ListLive::class)
        ->name('users.index');

    Route::get('users/{user}', App\Livewire\User\ShowLive::class)
        ->name('users.show');

    Route::get('users/{user}/roles/assignment', App\Livewire\User\RoleAssignmentLive::class)
        ->name('users.roles.assignment');

    Route::get('users/{user}/permissions/assignment', App\Livewire\User\PermissionAssignmentLive::class)
        ->name('users.permissions.assignment');

    Route::get('genres', App\Livewire\Genre\ListLive::class)
        ->name('genres.index');

    Route::get('authors', App\Livewire\Author\ListLive::class)
        ->name('authors.index');

    Route::get('authors/create', App\Livewire\Author\CreateLive::class)
        ->name('authors.create');

    Route::get('authors/{author}', App\Livewire\Author\ShowLive::class)
        ->name('authors.show');

    Route::get('authors/{author}/edit', App\Livewire\Author\EditLive::class)
        ->name('authors.edit');

    Route::get('books', App\Livewire\Book\ListLive::class)
        ->name('books.index');

    Route::get('books/create', App\Livewire\Book\CreateLive::class)
        ->name('books.create');

    Route::get('books/{book}/edit', App\Livewire\Book\EditLive::class)
        ->name('books.edit');

    Route::get('editorials', App\Livewire\Editorial\ListLive::class)
        ->name('editorials.index');

    Route::get('editions', App\Livewire\Edition\ListLive::class)
        ->name('editions.index');

    Route::get('editions/create', App\Livewire\Edition\CreateLive::class)
        ->name('editions.create');

    Route::get('editions/{edition}/edit', App\Livewire\Edition\EditLive::class)
        ->name('editions.edit');

    Route::get('copies', App\Livewire\Copy\ListLive::class)
        ->name('copies.index');

    Route::get('copies/create', App\Livewire\Copy\CreateLive::class)
        ->name('copies.create');

    Route::get('copies/{copy}/edit', App\Livewire\Copy\EditLive::class)
        ->name('copies.edit');
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
