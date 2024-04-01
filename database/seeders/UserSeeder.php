<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Andrés Montero',
                'email' => 'admin@test.com',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'secretary@test.com',
            ],
            [
                'name' => 'Lector',
                'email' => 'lector@test.com',
            ],
        ];

        DB::table('users')->insertOrIgnore(
            array_map(
                fn($user) => [
                        ...$user,
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                        'remember_token' => Str::random(10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                $users
            )
        );

        User::where('email', 'admin@test.com')->first()?->assignRole(RoleEnum::ADMIN->value);
        User::where('email', 'secretary@test.com')->first()?->assignRole(RoleEnum::SECRETARIO->value);
        User::where('email', 'lector@test.com')->first()?->assignRole(RoleEnum::LECTOR->value);

        User::factory()
            ->admin()
            ->count(2)
            ->create();

        User::factory()
            ->secretary()
            ->count(4)
            ->create();
    }
}
