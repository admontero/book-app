<?php

namespace Database\Seeders;

use App\Models\Edition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Edition::factory()->count(200)->existing()->create();
    }
}
