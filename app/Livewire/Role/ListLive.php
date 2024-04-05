<?php

namespace App\Livewire\Role;

use App\Traits\HasSort;
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

    public function mount()
    {
        $this->validateSorting(fields: ['id', 'name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function rolesCount(): int
    {
        return Role::count();
    }

    #[Computed]
    public function permissionsCount(): int
    {
        return Permission::count();
    }

    public function render()
    {
        $roles = Role::select('id', 'name')
            ->with('users:id,name,profile_photo_path', 'permissions:id,name')
            ->withCount('users', 'permissions')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.role.list-live', [
            'roles' => $roles,
        ]);
    }
}
