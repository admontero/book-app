<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Pseudonym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()
            ->count(100)
            ->create()
            ->each(function (Book $book) {
                $genres = Genre::inRandomOrder()->take(rand(1, 4))->pluck('id');

                $book->genres()->sync($genres);

                $pseudonyms = Pseudonym::inRandomOrder()->take(rand(1, 2))->pluck('id');

                $book->pseudonyms()->sync($pseudonyms);
            });
    }
}
