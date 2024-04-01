<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array_map(fn($role) => ['name' => $role->value], PermissionEnum::cases());

        DB::table('permissions')->insertOrIgnore(
            array_map(
                fn ($permission) => [...$permission, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                $permissions,
            )
        );

        Role::find(1)->syncPermissions(array_column($permissions, 'name'));
    }
}
