<?php

namespace App\Livewire\Permission;

use App\Livewire\Forms\PermissionForm;
use App\Models\Permission;
use App\Traits\HasSort;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
class ListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public ?Permission $permission = null;

    public PermissionForm $form;

    public array $sortableColumns = ['name'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setPermission(Permission $permission): void
    {
        $this->permission = $permission;

        $this->form->setPermission($permission);

        $this->dispatch('show-edit-permission-' . $permission->id)->self();
    }

    #[Computed]
    public function permissionsCount(): int
    {
        return Permission::count();
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('close-edit-permission-' . $this->permission->id)->self();
        $this->dispatch('new-alert', message: 'Permiso actualizado con éxito', type: 'success');
    }

    public function render(): View
    {
        $permissions = Permission::select(['id', 'name'])
            ->with(['users:id,name,profile_photo_path', 'roles:id,name'])
            ->withCount(['users', 'roles'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.permission.list-live', [
            'permissions' => $permissions,
        ]);
    }
}
