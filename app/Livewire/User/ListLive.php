<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Traits\HasSort;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $roles = '';

    public User $userSelected;

    public array $permissions = [];

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'name', 'email', 'roles.name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setRoles(string $name): void
    {
        $rolesFilterArray = array_filter(explode(',', $this->roles));

        if (in_array($name, $rolesFilterArray)) {
            $rolesFilterArray = array_diff($rolesFilterArray, [$name]);
        } else {
            $rolesFilterArray[] = $name;
        }

        $this->roles = implode(',', $rolesFilterArray);
        $this->resetPage();
    }

    #[Computed]
    public function rolesArray(): array
    {
        return array_filter(explode(',', $this->roles));
    }

    #[Computed]
    public function usersCount(): int
    {
        return User::count();
    }

    #[Computed]
    public function permissionsCount(): int
    {
        return Permission::count();
    }

    #[Computed]
    public function allRoles(): Collection
    {
        return Role::pluck('name', 'id');
    }

    public function render(): View
    {
        $users = tap(User::select('users.id', 'users.name', 'users.email')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->with('roles:id,name', 'permissions:id,name', 'roles.permissions:id,name')
            ->when($this->rolesArray, function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->whereIn('name', $this->rolesArray);
                });
            })
            ->where(function ($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10))
            ->transform(function ($user) {
                $user->permissions_count = count($user->permissions->merge($user->roles->flatMap(fn ($role) => $role->permissions)));

                return $user;
            });

        return view('livewire.user.list-live', [
            'users' => $users,
        ]);
    }
}
