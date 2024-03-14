<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\HolidayPlan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        HolidayPlan::factory(20)->create();
        $this->call(UsersTableSeeder::class);
    }
}
