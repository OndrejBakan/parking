<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilitiesToInsert = [
            [
                'source_id' => 1,
                'name' => 'Parkovací dům DOMINI PARK',
                'description' => '',
                'address' => 'Husova 712/14a, Brno',
                'latitude' => 49.19447,
                'longitude' => 16.6056528,
            ],
            [
                'source_id' => 2,
                'name' => 'P + R parkovací dům RIVER PARK',
                'description' => '',
                'address' => 'Polní 1033/35, Brno',
                'latitude' => 49.18225,
                'longitude' => 16.60181,
            ],
            [
                'source_id' => 3,
                'name' => 'Parkovací dům PINKI PARK',
                'description' => '',
                'address' => 'Kopečná 998/24, Brno',
                'latitude' => 49.1903733,
                'longitude' => 16.6049692,
            ],
            [
                'source_id' => 4,
                'name' => 'Parkoviště Benešova',
                'description' => 'naproti hotelu Grand',
                'address' => '',
                'latitude' => 49.1926839,
                'longitude' => 16.6140764,
            ],
            [
                'source_id' => 5,
                'name' => 'Parkoviště Veveří',
                'description' => '',
                'address' => '',
                'latitude' => 49.2072989,
                'longitude' => 16.5925664,
            ],
            [
                'source_id' => 6,
                'name' => 'Parking u Janáčkova divadla',
                'description' => '',
                'address' => '',
                'latitude' => 49.1990306,
                'longitude' => 16.6094689,
            ],
            [
                'source_id' => 7,
                'name' => 'Parkoviště Skořepka',
                'description' => '',
                'address' => '',
                'latitude' => 49.1923911,
                'longitude' => 16.6177942,
            ],
            [
                'source_id' => 8,
                'name' => 'P+R u Ústředního hřbitova',
                'description' => '',
                'address' => '',
                'latitude' => 49.1701456,
                'longitude' => 16.5987353,
            ],
            [
                'source_id' => 9,
                'name' => 'P+R Líšeň u Zetoru',
                'description' => '',
                'address' => '',
                'latitude' => 49.2001003,
                'longitude' => 16.6696408,
            ],
        ];

        Facility::insert($facilitiesToInsert);
    }
}