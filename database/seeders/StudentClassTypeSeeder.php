<?php

namespace Database\Seeders;

use App\Models\Landlord\ClassRoomType;
use App\Models\Landlord\Discipline;
use App\Models\Landlord\DisciplineTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder of Discipline and DisciplineTests
         */
        DB::table('disciplines')->truncate();
        DB::table('discipline_tests')->truncate();

        $disciplines = [
            [
                'code' => 'FR',
                'name' => 'Français',
                'tests' => [
                    [
                        'code' => 'ECR',
                        'name' => 'Ecriture'
                    ],
                    [
                        'code' => 'EXP',
                        'name' => 'Expression écrite'
                    ],
                    [
                        'code' => 'DIC',
                        'name' => 'Dictée'
                    ],
                    [
                        'code' => 'EXT',
                        'name' => 'Exploitation de texte'
                    ],
                    [
                        'code' => 'LEC',
                        'name' => 'Lecture'
                    ],
                    [
                        'code' => 'COP',
                        'name' => 'copie'
                    ],
                ]
            ],
            [
                'code' => 'MATHS',
                'name' => 'Mathématique',
                'tests' => [
                    [
                        'code' => 'MATH',
                        'name' => 'Mathématique'
                    ],
                ]
            ],
            [
                'code' => 'EDHC',
                'name' => 'EDHC',
                'tests' => [
                    [
                        'code' => 'EDHC',
                        'name' => 'EDHC'
                    ],
                ]
            ],
            [
                'code' => 'EPS',
                'name' => 'EPS'
            ],
            [
                'code' => 'AEC',
                'name' => 'AEC',
                'tests' => [
                    [
                        'code' => 'DES',
                        'name' => 'Dessin'
                    ],
                ]
            ],
            [
                'code' => 'HG',
                'name' => 'Histoire-Géographie',
                'tests' => [
                    [
                        'code' => 'EVE',
                        'name' => 'Éveil au milieu'
                    ],
                ]
            ],
            [
                'code' => 'ST',
                'name' => 'Science et Technologie'
            ],
        ];

        foreach($disciplines as $d) {
            $discipline = Discipline::create([
                'code' => $d['code'],
                'name' => $d['name'],
            ]);

            if (isset($d['tests'])) {
                foreach($d['tests'] as $test) {
                    $discipline->disciplineTests()->create($test);
                }
            }
        }

        /**
         * Seeder of School class types
         */
        DB::table('class_room_types')->truncate();

        $classTypes =  [
            [
                'code' => 'CP1',
                'name' => 'CP1',
                'description' => 'Cours préparatoire prémière année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC'],
                'test_coefficient' => 10,
                'tests' => ['ECR', 'DES', 'EXP', 'LEC', 'COP', 'MATH', 'EDHC', 'DIC'],
            ],
            [
                'code' => 'CP2',
                'name' => 'CP2',
                'description' => 'Cours préparatoire deuxième année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC'],
                'test_coefficient' => 10,
                'tests' => ['ECR', 'DES', 'EXP', 'LEC', 'COP', 'MATH', 'EDHC', 'DIC'],
            ],
            [
                'code' => 'CE1',
                'name' => 'CE1',
                'description' => 'Cours élémentaire prémière année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC', 'HG', 'ST'],
                'test_coefficient' => 10,
                'tests' => ['EVE', 'EXT', 'MATH', 'DIC'],
            ],
            [
                'code' => 'CE2',
                'name' => 'CE2',
                'description' => 'Cours élémentaire deuxième année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC', 'HG', 'ST'],
                'test_coefficient' => 10,
                'tests' => ['EVE', 'EXT', 'MATH', 'DIC'],
            ],
            [
                'code' => 'CM1',
                'name' => 'CM1',
                'description' => 'Cours moyen prémière année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC', 'HG', 'ST'],
                'test_coefficient' => 20,
                'tests' => ['EVE', 'EXT', 'MATH', 'DIC'],
            ],
            [
                'code' => 'CM2',
                'name' => 'CM2',
                'description' => 'Cours moyen deuxième année.',
                'disciplines' => ['FR', 'MATHS', 'EDHC', 'EPS', 'AEC', 'HG', 'ST'],
                'test_coefficient' => 20,
                'tests' => ['EVE', 'EXT', 'MATH', 'DIC'],
            ],
        ];

        foreach ($classTypes as $type) {
            $class = ClassRoomType::create([
                'code' => $type['code'],
                'name' => $type['name'],
                'description' => $type['description'],
            ]);

            $disciplines = Discipline::whereIn('code', $type['disciplines'])->pluck('id')->toArray();

            $class->disciplines()->attach($disciplines);

            $tests = DisciplineTest::whereIn('code', $type['tests'])->pluck('id')->toArray();

            $class->disciplineTests()->attach($tests, [
                'coefficient' => $type['test_coefficient']
            ]);
        }
    }
}
