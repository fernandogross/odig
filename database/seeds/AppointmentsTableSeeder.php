<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointments')->insert([
			'start_date' => '2019-09-02',
			'concluded_date' => null,
			'deadline' => '2019-09-06',
			'status' => 0,
			'title' => 'Study about Laravel',
			'description' => 'Cover basic CRUD and Auth.',
			'user' => 'Fernando',
			'created_at' => Carbon::now()
        ]);

        DB::table('appointments')->insert([
			'start_date' => '2019-09-09',
			'concluded_date' => null,
			'deadline' => '2019-09-13',
			'status' => 0,
			'title' => 'Build Rest API',
			'description' => 'Develop a Rest API using Laravel.',
			'user' => 'Fernando',
			'created_at' => Carbon::now()
        ]);

        DB::table('appointments')->insert([
			'start_date' => '2019-09-16',
			'concluded_date' => null,
			'deadline' => '2019-09-20',
			'status' => 0,
			'title' => 'Build Tests for Rest API',
			'description' => 'Cover every method of Appointments Service and Repository.',
			'user' => 'Fernando',
			'created_at' => Carbon::now()
        ]);
    }
}
