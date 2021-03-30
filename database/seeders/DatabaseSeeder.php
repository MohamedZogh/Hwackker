<?php

namespace Database\Seeders;

use App\Models\Hwack;
use App\Models\User;
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
        User::factory(10)
            ->has(Hwack::factory()->count(1000))
            ->create();
    }
}
