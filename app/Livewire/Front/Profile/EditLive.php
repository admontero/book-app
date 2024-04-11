<?php

namespace App\Livewire\Front\Profile;

use App\Livewire\Front\NavigationMenuLive;
use App\Models\DocumentType;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditLive extends Component
{
    use WithFileUploads;

    public $photo;

    public $name;

    public $email;

    public $document_type_id;

    public $document_number;

    public $phone;

    public function mount(): void
    {
        $this->fill($this->user);

        $this->document_type_id = $this->user->profile->document_type_id;
        $this->document_number = $this->user->profile->document_number;
        $this->phone = $this->user->profile->phone;
    }

    public function validationAttributes(): array
    {
        return [
            'photo' => 'imagen de perfil',
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'document_type_id' => 'tipo de documento',
            'document_number' => 'número de documento',
            'phone' => 'teléfono',
        ];
    }

    public function updateProfileInformation(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'document_type_id' => ['nullable', Rule::exists('document_types', 'id'), Rule::requiredIf(fn () => $this->document_number)],
            'document_number' => ['nullable', Rule::requiredIf(fn () => $this->document_type_id), 'max:255'],
            'phone' => ['nullable', 'max:255'],
        ]);

        if ($this->photo) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        Profile::updateOrCreate([
            'user_id' => $this->user->id,
        ], [
            'user_id' => $this->user->id,
            'document_type_id' => $this->document_type_id ? $this->document_type_id : null,
            'document_number' => $this->document_number,
            'phone' => $this->phone,
        ]);

        unset($this->user);

        $this->dispatch('refresh-photo');

        $this->dispatch('new-alert', message: 'Perfil actualizado con éxito', type: 'success');
    }

    public function deleteProfilePhoto(): void
    {
        if ($this->user && $this->user->profile_photo_path && Storage::disk('public')->exists($this->user->profile_photo_path)) {
            Storage::disk('public')->delete($this->user->profile_photo_path);
        }

        $this->user->forceFill([
            'profile_photo_path' => null,
        ])->save();

        unset($this->user);

        $this->dispatch('refresh-photo');
    }

    #[Computed(cache: true)]
    public function document_types(): Collection
    {
        return DocumentType::select('id', 'name', 'abbreviation')->get();
    }

    #[Computed]
    public function user()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.front.profile.edit-live');
    }
}
