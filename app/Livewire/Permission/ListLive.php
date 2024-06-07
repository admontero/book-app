<?php

namespace App\Livewire\Permission;

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

    public array $sortableColumns = ['name'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function permissionsCount(): int
    {
        return Permission::count();
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
