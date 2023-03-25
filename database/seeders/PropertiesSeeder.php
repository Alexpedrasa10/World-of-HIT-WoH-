<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'category' => 'TPLAY',
                'code' => null,
                'description' => 'Type of players'
            ],
            [
                'category' => 'TPLAY',
                'code' => 'HUM',
                'description' => 'Human'
            ],
            [
                'category' => 'TPLAY',
                'code' => 'ZOM',
                'description' => 'Zombie'
            ],

            [
                'category' => 'TITEM',
                'code' => null,
                'description' => 'Type of item'
            ],
            [
                'category' => 'TITEM',
                'code' => 'BOOT',
                'description' => 'Boot'
            ],
            [
                'category' => 'TITEM',
                'code' => 'SHI',
                'description' => 'Shield'
            ],
            [
                'category' => 'TITEM',
                'code' => 'WAEA',
                'description' => 'Weapon'
            ],

            //aaa
            [
                'category' => 'TATT',
                'code' => null,
                'description' => 'Type of attack'
            ],
            [
                'category' => 'TATT',
                'code' => 'BODY',
                'description' => 'Body to body'
            ],
            [
                'category' => 'TATT',
                'code' => 'DIST',
                'description' => 'Distance'
            ],
        ];


        foreach ($properties as $prop) {
            
            Property::updateOrCreate([
                'category' => $prop['category'],
                'code' => $prop['code'],
            ], [
                'description' => $prop['description']
            ]);
        }
    }
}
