<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {

    }

    public function runLandlordSpecificSeeders()
    {
        $this->call(AdminSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(WeekDayTableSeeder::class);
        $this->call(StudentClassTypeSeeder::class);
    }
}
