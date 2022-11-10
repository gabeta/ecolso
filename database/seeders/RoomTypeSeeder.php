<?php

namespace Database\Seeders;

use App\Models\Landlord\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->truncate();

        $data = [
            [
                'code' => 'ENS',
                'name' => 'Enseignements',
                'sub' => [
                    [
                        'code' => 'SAC',
                        'name' => 'Salle de classe',
                    ],
                    [
                        'code' => 'SAP',
                        'name' => 'Salle pré-scolaire',
                    ],
                ],
            ],
            [
                'code' => 'ADM',
                'name' => 'Administration',
                'sub' => [
                    [
                        'code' => 'BUD',
                        'name' => 'Bureau du directeur',
                    ],
                    [
                        'code' => 'SEC',
                        'name' => 'Sécrétariat',
                    ],
                    [
                        'code' => 'ARC',
                        'name' => 'Local d\'archive',
                    ],
                ],
            ],
            [
                'code' => 'SPE',
                'name' => 'Spécial',
                'sub' => [
                    [
                        'code' => 'BIB',
                        'name' => 'Bibliothèque',
                    ],
                    [
                        'code' => 'INF',
                        'name' => 'Salle d\'informatique',
                    ],
                ],
            ],
            [
                'code' => 'DIV',
                'name' => 'Divertissement',
                'sub' => [
                    [
                        'code' => 'COR',
                        'name' => 'Cours de récréation',
                    ],
                    [
                        'code' => 'TFO',
                        'name' => 'Terrain de foot',
                    ],
                    [
                        'code' => 'TBA',
                        'name' => 'Terrain de basketball',
                    ],
                    [
                        'code' => 'PIS',
                        'name' => 'Piscine',
                    ],
                ],
            ],
            [
                'code' => 'SAN',
                'name' => 'Sanitaire & Santé',
                'sub' => [
                    [
                        'code' => 'TOL',
                        'name' => 'Toilette',
                    ],
                    [
                        'code' => 'VES',
                        'name' => 'Vestiaire',
                    ],
                    [
                        'code' => 'LVM',
                        'name' => 'Lave mains',
                    ],
                    [
                        'code' => 'IFM',
                        'name' => 'Infirmerie',
                    ],
                ],
            ],
            [
                'code' => 'COM',
                'name' => 'Complementaire',
                'sub' => [
                    [
                        'code' => 'CAN',
                        'name' => 'Cantine',
                    ],
                    [
                        'code' => 'LOG',
                        'name' => 'Loge gardien',
                    ],
                    [
                        'code' => 'CUI',
                        'name' => 'Cuisine',
                    ],
                    [
                        'code' => 'POU',
                        'name' => 'Poubelle',
                    ],
                    [
                        'code' => 'DOR',
                        'name' => 'Dortoir',
                    ],
                ],
            ]
        ];

        foreach ($data as $d) {
            $type = RoomType::create([
                'code' => $d['code'],
                'name' => $d['name'],
            ]);

            foreach($d['sub'] as $sub) {
                $type->children()->create([
                    'code' =>  $sub['code'],
                    'name' =>  $sub['name'],
                ]);
            }
        }
    }
}
