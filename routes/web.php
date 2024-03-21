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
    Route::get('roles', App\Livewire\RoleListLive::class)
        ->name('roles.index');

    Route::get('roles/{role}', App\Livewire\RoleShowLive::class)
        ->name('roles.show');

    Route::get('roles/{role}/permissions/assignment', App\Livewire\RolePermissionAssignmentLive::class)
        ->name('roles.permissions.assignment');

    Route::get('permissions', App\Livewire\PermissionListLive::class)
        ->name('permissions.index');

    Route::get('users', App\Livewire\UserListLive::class)
        ->name('users.index');

    Route::get('users/{user}', App\Livewire\UserShowLive::class)
        ->name('users.show');

    Route::get('users/{user}/roles/assignment', App\Livewire\UserRoleAssignmentLive::class)
        ->name('users.roles.assignment');

    Route::get('users/{user}/permissions/assignment', App\Livewire\UserPermissionAssignmentLive::class)
        ->name('users.permissions.assignment');

    Route::get('genres', App\Livewire\GenreListLive::class)
        ->name('genres.index');

    Route::get('authors', App\Livewire\AuthorListLive::class)
        ->name('authors.index');

    Route::get('authors/create', App\Livewire\AuthorCreateLive::class)
        ->name('authors.create');

    Route::get('authors/{author}', App\Livewire\AuthorShowLive::class)
        ->name('authors.show');

    Route::get('authors/{author}/edit', App\Livewire\AuthorEditLive::class)
        ->name('authors.edit');

    Route::get('books', App\Livewire\BookListLive::class)
        ->name('books.index');

    Route::get('books/create', App\Livewire\BookCreateLive::class)
        ->name('books.create');

    Route::get('books/{book}/edit', App\Livewire\BookEditLive::class)
        ->name('books.edit');

    Route::get('editorials', App\Livewire\EditorialListLive::class)
        ->name('editorials.index');

    Route::get('editions', App\Livewire\EditionListLive::class)
        ->name('editions.index');

    Route::get('editions/create', App\Livewire\EditionCreateLive::class)
        ->name('editions.create');

    Route::get('editions/{edition}/edit', App\Livewire\EditionEditLive::class)
        ->name('editions.edit');

    Route::get('copies', App\Livewire\CopyListLive::class)
        ->name('copies.index');

    Route::get('copies/create', App\Livewire\CopyCreateLive::class)
        ->name('copies.create');

    Route::get('copies/{copy}/edit', App\Livewire\CopyEditLive::class)
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
