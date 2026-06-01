<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'slug' => 'rapido-8094-df',
                'name' => 'Rapido 8094 DF',
                'brand' => 'Rapido',
                'price_per_day' => 185,
                'description' => 'Perfilada premium con cama isla, salón amplio y cocina completa. Ideal para rutas largas en pareja o familia pequeña.',
                'images' => [
                    'https://cdn.yakartautocaravanas.com/s/c/vehiculos/images/316/4726.jpg',
                    'https://cdn.yakartautocaravanas.com/s/c/vehiculos/images/316/zoom/4727.jpg',
                    'https://cdn.yakartautocaravanas.com/s/c/vehiculos/images/316/zoom/4728.jpg',
                    'https://cdn.yakartautocaravanas.com/s/c/vehiculos/images/316/zoom/4725.jpg',
                ],
                'features' => ['Cama isla', 'Cocina de 3 fuegos', 'Baño separado', 'Placa solar'],
                'capacity' => 4,
                'transmission' => 'Manual',
                'fuel' => 'Diésel',
                'is_active' => true,
            ],
            [
                'slug' => 'rapido-9094-df',
                'name' => 'Rapido 9094 DF',
                'brand' => 'Rapido',
                'price_per_day' => 210,
                'description' => 'Autocaravana integral de alta gama con acabados de lujo, gran almacenamiento y excelente aislamiento térmico.',
                'images' => [
                    'https://www.motorhomedepot.com/media/size/product_zoom/4279-71c340ca95.jpeg',
                    'https://www.motorhomedepot.com/media/size/product_zoom/4279-3e5ea1c24f.jpeg',
                    'https://www.motorhomedepot.com/media/size/product_zoom/4279-f35f29f7e6.jpeg',
                ],
                'features' => ['Acabado integral', 'Climatización automática', 'Navegador', 'Garaje XXL'],
                'capacity' => 4,
                'transmission' => 'Automática',
                'fuel' => 'Diésel',
                'is_active' => true,
            ],
            [
                'slug' => 'benimar-mileo-282',
                'name' => 'Benimar Mileo 282',
                'brand' => 'Benimar',
                'price_per_day' => 165,
                'description' => 'Modelo muy equilibrado con camas gemelas convertibles, excelente distribución interior y consumo eficiente.',
                'images' => [
                    'https://www.autocaravanasmartinez.com/media/pages/autocaravanas/benimar-mileo-282/322521394-1649839806/2a3e7759-deef-4d13-9b8b-78fbc884f4bc-640x480.jpg',
                    'https://www.autocaravanasmartinez.com/media/pages/autocaravanas/benimar-mileo-282/2086838271-1649839816/b1896606-6521-4e54-9741-aa24e514e901-1800x.jpg',
                    'https://www.autocaravanasmartinez.com/media/pages/autocaravanas/benimar-mileo-282/3109625249-1649839844/376a4963-cb42-4481-b298-7db692e079b9-1800x.jpg',
                ],
                'features' => ['Camas gemelas', 'Nevera grande', 'Toldo exterior', 'Cámara trasera'],
                'capacity' => 5,
                'transmission' => 'Manual',
                'fuel' => 'Diésel',
                'is_active' => true,
            ],
            [
                'slug' => 'burstner-lyseo-td-744',
                'name' => 'Bürstner Lyseo TD 744',
                'brand' => 'Bürstner',
                'price_per_day' => 178,
                'description' => 'Confort alemán, distribución muy práctica y salón luminoso para familias que buscan comodidad en carretera.',
                'images' => [
                    'https://www.truck1.es/img/xxl/7079/BURSTNER-Campeo-TD-676-Autom-6-Schlafplatze-Alemania_7079_9245113586.jpg',
                    'https://www.truck1.es/img/xxl/7079/BURSTNER-Campeo-TD-676-Autom-6-Schlafplatze-Alemania_7079_3993447150.jpg',
                    'https://www.truck1.es/img/xxl/7079/BURSTNER-Campeo-TD-676-Autom-6-Schlafplatze-Alemania_7079_10451232.jpg',
                ],
                'features' => ['Cama basculante', 'ISOFIX', 'Ducha independiente', 'Control crucero'],
                'capacity' => 5,
                'transmission' => 'Automática',
                'fuel' => 'Diésel',
                'is_active' => true,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['slug' => $vehicle['slug']],
                $vehicle
            );
        }
    }
}