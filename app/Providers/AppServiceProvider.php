<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Events\LoanCreated;
use App\Listeners\UpdateCopyStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Edition;
use App\Models\Editorial;
use App\Models\Genre;
use App\Models\Pseudonym;
use App\Models\User;
use App\Observers\AuthorObserver;
use App\Observers\BookObserver;
use App\Observers\CopyObserver;
use App\Observers\EditionObserver;
use App\Observers\EditorialObserver;
use App\Observers\GenreObserver;
use App\Observers\PseudonymObserver;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //if ($this->app->environment() != 'production') {
        //    ! request()->header('x-forwarded-host') ?: request()->headers->set('host', request()->header('x-forwarded-host'));
        //}

        Gate::define('access-backoffice', function (User $user) {
            return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::SECRETARIO->value])
                ? Response::allow()
                : Response::denyAsNotFound();
        });

        Gate::define('access-frontoffice', function (User $user) {
            return $user->hasRole(RoleEnum::LECTOR->value);
        });

        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);

        Genre::observe(GenreObserver::class);
        Author::observe(AuthorObserver::class);
        Pseudonym::observe(PseudonymObserver::class);
        Editorial::observe(EditorialObserver::class);
        Book::observe(BookObserver::class);
        Edition::observe(EditionObserver::class);
        Copy::observe(CopyObserver::class);

        Event::listen(LoanCreated::class, UpdateCopyStatus::class);
    }
}
