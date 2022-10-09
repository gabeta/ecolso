<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeekDayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('week_days')
            ->insert([
                [
                    'name' => 'Lundi',
                ],
                [
                    'name' => 'Mardi',
                ],
                [
                    'name' => 'Mercredi',
                ],
                [
                    'name' => 'Jeudi',
                ],
                [
                    'name' => 'Vendredi',
                ],
                [
                    'name' => 'Samedi',
                ],
                [
                    'name' => 'Dimanche',
                ]
            ]);
    }
}
