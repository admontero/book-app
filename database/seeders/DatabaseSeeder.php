<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $admin = User::factory()->create([
            'name' => 'Andrés Montero',
            'email' => 'admin@test.com',
        ]);

        $secretary = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'secretary@test.com',
        ]);

        $adminRole = Role::create(['name' => 'administrador']);
        $secretaryRole = Role::create(['name' => 'secretario']);
        $readerRole = Role::create(['name' => 'lector']);

        $admin->assignRole($adminRole);
        $secretary->assignRole($secretaryRole);

        User::factory()
            ->admin()
            ->count(6)
            ->create();

        User::factory()
            ->secretary()
            ->count(5)
            ->create();

        $viewUsersPermission = Permission::create(['name' => 'ver usuarios']);
        $createUsersPermission = Permission::create(['name' => 'crear usuarios']);
        $updateUsersPermission = Permission::create(['name' => 'actualizar usuarios']);
        $deleteUsersPermission = Permission::create(['name' => 'eliminar usuarios']);

        $viewRolesPermission = Permission::create(['name' => 'ver roles']);
        $createRolesPermission = Permission::create(['name' => 'crear roles']);
        $updateRolesPermission = Permission::create(['name' => 'actualizar roles']);
        $deleteRolesPermission = Permission::create(['name' => 'eliminar roles']);

        $viewPermission = Permission::create(['name' => 'ver permisos']);

        $adminRole->syncPermissions([
            $viewUsersPermission,
            $createUsersPermission,
            $updateUsersPermission,
            $deleteUsersPermission,
            $viewRolesPermission,
            $createRolesPermission,
            $updateRolesPermission,
            $deleteRolesPermission,
            $viewPermission,
        ]);

        $this->call(WorldSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(AuthorSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
