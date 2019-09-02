<?php

use Illuminate\Database\Seeder;
use AppointmentsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppointmentsTableSeeder::class);
    }
}
