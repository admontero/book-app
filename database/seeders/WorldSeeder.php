<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Nnjeim\World\Actions\SeedAction;

class WorldSeeder extends Seeder
{
	public function run()
	{
        Schema::disableForeignKeyConstraints();
		$this->call(SeedAction::class);
        Schema::enableForeignKeyConstraints();
	}
}
