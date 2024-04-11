<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Cédula de Ciudadanía',
                'abbreviation' => 'C.C.',
            ],
            [
                'name' => 'Tarjeta de Identidad',
                'abbreviation' => 'T.I.',
            ],
            [
                'name' => 'Pasaporte',
                'abbreviation' => 'P.',
            ],
            [
                'name' => 'Cédula de Extranjería',
                'abbreviation' => 'C.E.',
            ],
        ];

        DB::table('document_types')->insertOrIgnore(
            array_map(fn ($type) => [...$type, 'created_at' => now(), 'updated_at' => now()], $types)
        );
    }
}
