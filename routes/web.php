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

require_once __DIR__ . '/jetstream.php';

Route::group([
    'middleware' => ['auth', config('jetstream.auth_session'), 'can:access-backoffice'],
    'prefix' => 'back',
    'as' => 'back.'
], function () {

    Route::get('', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('roles', App\Livewire\Role\ListLive::class)
        ->middleware('can:viewAny,Spatie\Permission\Models\Role')
        ->name('roles.index');

    Route::get('roles/{role}', App\Livewire\Role\ShowLive::class)
        ->middleware('can:view,role')
        ->name('roles.show');

    Route::get('roles/{role}/permissions/assignment', App\Livewire\Role\PermissionAssignmentLive::class)
        ->middleware('can:assignPermission,Spatie\Permission\Models\Role')
        ->name('roles.permissions.assignment');

    Route::get('permissions', App\Livewire\Permission\ListLive::class)
        ->middleware('can:viewAny,Spatie\Permission\Models\Permission')
        ->name('permissions.index');

    Route::get('users', App\Livewire\User\ListLive::class)
        ->middleware('can:viewAny,App\Models\User')
        ->name('users.index');

    Route::get('users/{user}', App\Livewire\User\ShowLive::class)
        ->middleware('can:view,user')
        ->name('users.show');

    Route::get('users/{user}/roles/assignment', App\Livewire\User\RoleAssignmentLive::class)
        ->middleware('can:assignRole,App\Models\User')
        ->name('users.roles.assignment');

    Route::get('users/{user}/permissions/assignment', App\Livewire\User\PermissionAssignmentLive::class)
        ->middleware('can:assignPermission,App\Models\User')
        ->name('users.permissions.assignment');

    Route::get('genres', App\Livewire\Genre\ListLive::class)
        ->middleware('can:viewAny,App\Models\Genre')
        ->name('genres.index');

    Route::get('authors', App\Livewire\Author\ListLive::class)
        ->middleware('can:viewAny,App\Models\Author')
        ->name('authors.index');

    Route::get('authors/create', App\Livewire\Author\CreateLive::class)
        ->middleware('can:create,App\Models\Author')
        ->name('authors.create');

    Route::get('authors/{author}', App\Livewire\Author\ShowLive::class)
        ->middleware('can:view,author')
        ->name('authors.show');

    Route::get('authors/{author}/edit', App\Livewire\Author\EditLive::class)
        ->middleware('can:update,author')
        ->name('authors.edit');

    Route::get('books', App\Livewire\Book\ListLive::class)
        ->middleware('can:viewAny,App\Models\Book')
        ->name('books.index');

    Route::get('books/create', App\Livewire\Book\CreateLive::class)
        ->middleware('can:create,App\Models\Book')
        ->name('books.create');

    Route::get('books/{book}/edit', App\Livewire\Book\EditLive::class)
        ->middleware('can:update,book')
        ->name('books.edit');

    Route::get('editorials', App\Livewire\Editorial\ListLive::class)
        ->middleware('can:viewAny,App\Models\Editorial')
        ->name('editorials.index');

    Route::get('editions', App\Livewire\Edition\ListLive::class)
        ->middleware('can:viewAny,App\Models\Edition')
        ->name('editions.index');

    Route::get('editions/create', App\Livewire\Edition\CreateLive::class)
        ->middleware('can:create,App\Models\Edition')
        ->name('editions.create');

    Route::get('editions/{edition}/edit', App\Livewire\Edition\EditLive::class)
        ->middleware('can:update,edition')
        ->name('editions.edit');

    Route::get('copies', App\Livewire\Copy\ListLive::class)
        ->middleware('can:viewAny,App\Models\Copy')
        ->name('copies.index');

    Route::get('copies/create', App\Livewire\Copy\CreateLive::class)
        ->middleware('can:create,App\Models\Copy')
        ->name('copies.create');

    Route::get('copies/{copy}/edit', App\Livewire\Copy\EditLive::class)
        ->middleware('can:update,copy')
        ->name('copies.edit');
});

Route::group([
    'middleware' => ['auth', config('jetstream.auth_session'), 'can:access-frontoffice'],
    'as' => 'front.'
], function () {

    Route::get('profile', App\Livewire\Front\Profile\ShowLive::class)->name('profile.show');
});

Route::get('/', App\Livewire\Front\DashboardLive::class)->name('front.dashboard');

