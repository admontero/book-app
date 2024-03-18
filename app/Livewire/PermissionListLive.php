<?php

namespace App\Livewire;

use App\Traits\HasSort;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public ?Permission $permission = null;

    #[Validate('nullable|max:180')]
    public string $description = '';

    public function mount()
    {
        $this->validateSorting(fields: ['name']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setPermission(Permission $permission)
    {
        $this->permission = $permission;

        $this->description = $permission->description ?? '';

        $this->resetErrorBag();

        $this->dispatch('show-edit-description-' . $permission->id)->self();
    }

    #[Computed]
    public function permissionsCount(): int
    {
        return Permission::count();
    }

    public function saveDescription(): void
    {
        if (! $this->permission) return ;

        $this->validate();

        $this->permission->update([
            'description' => $this->description,
        ]);

        $this->dispatch('close-edit-description-' . $this->permission->id)->self();
    }

    public function render()
    {
        $permissions = Permission::select('id', 'name')
            ->with('users:id,name,profile_photo_path', 'roles:id,name')
            ->withCount('users', 'roles')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.permission-list-live', [
            'permissions' => $permissions,
        ]);
    }
}
