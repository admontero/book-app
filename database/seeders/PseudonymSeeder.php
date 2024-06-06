<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Pseudonym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PseudonymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pseudonym::factory()
            ->count(100)
            ->recycle(Author::get('id'))
            ->create();
    }
}
