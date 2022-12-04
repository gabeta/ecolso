<?php

namespace Database\Seeders;

use Domain\Admins\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin Ecolso',
            'email' => 'gabeta.soro@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
    }
}
