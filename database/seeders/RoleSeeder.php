<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore(
            array_map(
                fn ($role) => [...$role, 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                array_map(fn($role) => ['name' => $role->value], RoleEnum::cases())
            )
        );
    }
}
