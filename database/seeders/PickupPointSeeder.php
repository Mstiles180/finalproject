<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PickupPoint;

class PickupPointSeeder extends Seeder
{
    public function run()
    {
        $pickupPoints = [
            [
                'name' => 'Kigali City Center',
                'location_description' => 'Central Kigali near the city hall and main plaza',
            ],
            [
                'name' => 'Remera Junction',
                'location_description' => 'Major transport hub near Remera stadium',
            ],
            [
                'name' => 'Kimironko Market',
                'location_description' => 'Busy market area with local businesses',
            ],
            [
                'name' => 'Gikondo Industrial',
                'location_description' => 'Industrial zone with factory workers',
            ],
            [
                'name' => 'Kacyiru Government',
                'location_description' => 'Government offices and administrative buildings',
            ],
            [
                'name' => 'Kibagabaga Residential',
                'location_description' => 'Residential area with family homes',
            ],
            [
                'name' => 'Kicukiro Center',
                'location_description' => 'Kicukiro district center with local services',
            ],
            [
                'name' => 'Nyarugenge Market',
                'location_description' => 'Traditional market area with local vendors',
            ],
        ];

        foreach ($pickupPoints as $pickupPoint) {
            PickupPoint::create($pickupPoint);
        }
    }
} 