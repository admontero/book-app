<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WorldSeeder::class,
            DocumentTypeSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            GenreSeeder::class,
            AuthorSeeder::class,
            PseudonymSeeder::class,
            BookSeeder::class,
            EditorialSeeder::class,
            EditionSeeder::class,
            CopySeeder::class,
            LoanSeeder::class,
        ]);
    }
}
