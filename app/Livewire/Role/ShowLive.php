<?php

namespace App\Livewire\Role;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShowLive extends Component
{
    use WithPagination;

    public Role $role;

    public $usersSearch = '';

    public $permissionsSearch = '';

    #[Computed]
    public function totalUsers(): int
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('name', [$this->role->name]);
        })->count();
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::select('id', 'name', 'email', 'profile_photo_path')
            ->with([
                'profile:id,user_id,document_type_id,document_number,phone',
                'profile.document_type:id,name,abbreviation',
            ])
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [$this->role->name]);
            })
            ->when($this->usersSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->usersSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->usersSearch . '%');
            })
            ->latest('id')
            ->paginate(6, ['*'], 'usersPage');
    }

    #[Computed]
    public function totalPermissions(): int
    {
        return Permission::whereHas('roles', function ($query) {
            $query->whereIn('name', [$this->role->name]);
        })->count();
    }

    #[Computed]
    public function permissions(): LengthAwarePaginator
    {
        return Permission::select('id', 'name')
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [$this->role->name]);
            })
            ->when($this->permissionsSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->permissionsSearch . '%');
            })
            ->latest('id')
            ->paginate(6, ['*'], 'permissionsPage');
    }

    public function render()
    {
        return view('livewire.role.show-live');
    }
}
