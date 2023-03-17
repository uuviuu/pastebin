<?php

namespace Database\Seeders;

use App\Models\Paste;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Paste::factory(10)->create();
    }
}
