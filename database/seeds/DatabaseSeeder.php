<?php

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
        $this->call([

            UserSeeder::class, //caling user first, cuz product needs to pick from user
            ProductSeeder::class,
            ReviewSeeder::class,    ]);

    }
}
