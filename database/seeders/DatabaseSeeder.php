<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\State;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        CarType::factory()
            ->sequence(
                ['name' => 'Berline',],
                ['name' => 'Compacte',],
                ['name' => 'SUV',],
                ['name' => 'Pickup',],
                ['name' => 'Monospace',],
                ['name' => 'Tout-terrain',],
                ['name' => 'Coupé',],
                ['name' => 'Crossover',],
                ['name' => 'Voiture de sport'],
            )
            ->count(9)
            ->create();

        // Create fuel types
        // ['Gasoline', 'Diesel', 'Electric', 'Hybrid']
        FuelType::factory()
            ->sequence(
                ['name' => 'Essence'],
                ['name' => 'Diesel'],
                ['name' => 'Électrique'],
                ['name' => 'Hybride'],
            )
            ->count(4)
            ->create();

        // Create States with cities
        $regions = [
            'Tanger-Tétouan-Al Hoceima' => ['Tanger', 'Tétouan', 'Al Hoceima', 'Larache', 'Chefchaouen', 'Asilah', 'Ksar El Kébir', 'Ouezzane', 'M\'diq', 'Fnideq', 'Martil'],

            'L\'Oriental' => ['Oujda', 'Nador', 'Berkane', 'Taourirt', 'Jerada', 'Figuig', 'Ahfir', 'Saïdia', 'Bouarfa', 'Beni Ansar', 'Driouch', 'Guercif'],

            'Fès-Meknès' => ['Fès', 'Meknès', 'Taza', 'El Hajeb', 'Ifrane', 'Sefrou', 'Boulemane', 'Taounate', 'Moulay Yacoub', 'Midelt', 'Missour', 'Azrou', 'Errachidia'],

            'Rabat-Salé-Kénitra' => ['Rabat', 'Salé', 'Kénitra', 'Témara', 'Skhirate', 'Khémisset', 'Sidi Kacem', 'Sidi Slimane', 'Souk El Arbaa', 'Tiflet', 'Mechra Bel Ksiri'],

            'Béni Mellal-Khénifra' => ['Béni Mellal', 'Khénifra', 'Khouribga', 'Azilal', 'Fquih Ben Salah', 'Kasbah Tadla', 'Ouarzazate', 'Zaouiat Cheikh', 'Demnate', 'Boujad', 'Oued Zem'],

            'Casablanca-Settat' => ['Casablanca', 'Mohammedia', 'El Jadida', 'Settat', 'Berrechid', 'Benslimane', 'Médiouna', 'Nouaceur', 'Sidi Bennour', 'Ain Harrouda', 'Bouskoura', 'Tit Mellil', 'Deroua'],

            'Marrakech-Safi' => ['Marrakech', 'Safi', 'Essaouira', 'El Kelâa des Sraghna', 'Chichaoua', 'Youssoufia', 'Rehamna', 'Benguerir', 'Tamansourt', 'Amezmiz', 'Tahannaout', 'Attaouia'],

            'Drâa-Tafilalet' => ['Errachidia', 'Ouarzazate', 'Zagora', 'Tinghir', 'Midelt', 'Kelaat M\'Gouna', 'Rissani', 'Tinejdad', 'Erfoud', 'Boumalne Dadès', 'Tinerhir', 'Tamegroute'],

            'Souss-Massa' => ['Agadir', 'Inezgane', 'Taroudant', 'Tiznit', 'Chtouka Aït Baha', 'Tata', 'Ait Melloul', 'Dcheira El Jihadia', 'Biougra', 'Ouled Teima', 'Sidi Ifni', 'Oulad Berhil'],

            'Guelmim-Oued Noun' => ['Guelmim', 'Tan-Tan', 'Sidi Ifni', 'Assa', 'Zag', 'Bouizakarne', 'Lakhsas', 'Abaynou', 'Taghjijt', 'El Ouatia'],

            'Laâyoune-Sakia El Hamra' => ['Laâyoune', 'Es-Semara', 'Boujdour', 'Tarfaya', 'El Marsa', 'Dcheira', 'Foum El Oued', 'Hagounia'],

            'Dakhla-Oued Ed-Dahab' => ['Dakhla', 'Aousserd', 'Argoub', 'Bir Gandouz', 'El Guerguerate', 'Tichla', 'Lagouira']
        ];

        foreach ($regions as $region => $cities) {
            State::factory()
                ->state(['name' => $region])
                ->has(
                    City::factory()
                        ->count(count($cities))
                        ->sequence(...array_map(fn($city) => ['name' => $city], $cities))
                )
                ->create();
        }


        // Create makers with their corresponding models
        $makers = [
            'Dacia' => ['Logan', 'Sandero', 'Duster', 'Lodgy', 'Dokker', 'Spring', 'Jogger', 'Stepway'],
            'Renault' => ['Clio', 'Mégane', 'Kadjar', 'Captur', 'Symbol', 'Talisman', 'Kangoo', 'Trafic', 'Master', 'Koleos', 'Arkana', 'Express'],
            'Peugeot' => ['208', '308', '2008', '3008', '5008', '301', '508', 'Partner', 'Rifter', 'Expert', 'Traveller', '408'],
            'Citroën' => ['C3', 'C4', 'C-Elysée', 'Berlingo', 'Jumpy', 'C5 Aircross', 'C3 Aircross', 'Ami', 'DS3', 'DS4', 'DS7'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Tiguan', 'Touareg', 'Caddy', 'Jetta', 'Touran', 'T-Roc', 'Amarok', 'Arteon', 'Taigo'],
            'Ford' => ['Fiesta', 'Focus', 'Kuga', 'EcoSport', 'Transit', 'Ranger', 'Mustang', 'Puma', 'Explorer', 'Edge', 'Mondeo', 'Tourneo'],
            'Toyota' => ['Yaris', 'Corolla', 'RAV4', 'Prado', 'Hilux', 'Avanza', 'Camry', 'C-HR', 'Land Cruiser', 'Fortuner', 'Hiace', 'Supra'],
            'Hyundai' => ['i10', 'i20', 'i30', 'Accent', 'Tucson', 'Santa Fe', 'Creta', 'Kona', 'H1', 'Grand i10', 'Elantra', 'Ioniq'],
            'Kia' => ['Picanto', 'Rio', 'Cerato', 'Sportage', 'Sorento', 'Stonic', 'Ceed', 'Niro', 'Optima', 'K5', 'Soul', 'Seltos'],
            'Nissan' => ['Qashqai', 'Juke', 'X-Trail', 'Patrol', 'Micra', 'Navara', 'Sunny', 'Kicks', 'Altima', 'Almera', 'Note', 'Sentra'],
            'Fiat' => ['500', 'Panda', 'Tipo', 'Doblo', 'Fiorino', 'Punto', 'Qubo', '500X', '500L', 'Ducato', 'Talento', 'Fullback'],
            'SEAT' => ['Ibiza', 'Leon', 'Arona', 'Ateca', 'Tarraco', 'Toledo', 'Alhambra', 'Altea', 'Mii', 'Exeo', 'Cupra', 'Formentor'],
            'Skoda' => ['Fabia', 'Octavia', 'Superb', 'Kodiaq', 'Karoq', 'Kamiq', 'Rapid', 'Scala', 'Roomster', 'Yeti', 'Enyaq', 'Citigo'],
            'Mercedes-Benz' => ['Classe A', 'Classe C', 'Classe E', 'GLA', 'GLC', 'GLE', 'Classe S', 'Sprinter', 'Vito', 'CLA', 'GLB', 'Citan'],
            'BMW' => ['Série 1', 'Série 3', 'Série 5', 'X1', 'X3', 'X5', 'X6', 'X2', 'X4', 'Série 7', 'Série 4', 'Série 2'],
            'Audi' => ['A1', 'A3', 'A4', 'Q3', 'Q5', 'A6', 'Q7', 'A5', 'Q2', 'TT', 'A8', 'Q8'],
            'Opel' => ['Corsa', 'Astra', 'Insignia', 'Crossland', 'Grandland', 'Mokka', 'Combo', 'Zafira', 'Adam', 'Karl', 'Vivaro', 'Movano'],
            'Chevrolet' => ['Spark', 'Aveo', 'Cruze', 'Captiva', 'Trax', 'Orlando', 'Sonic', 'Tahoe', 'Silverado', 'Malibu', 'Blazer', 'Equinox'],
            'Honda' => ['Civic', 'CR-V', 'HR-V', 'Accord', 'Jazz', 'City', 'Pilot', 'WR-V', 'Odyssey', 'Fit', 'Amaze', 'BR-V'],
            'Mazda' => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-3', 'CX-5', 'CX-30', 'CX-9', 'BT-50', 'MX-5', 'MX-30', 'CX-60', 'CX-8'],
            'Mitsubishi' => ['L200', 'Pajero', 'ASX', 'Eclipse Cross', 'Outlander', 'Attrage', 'Xpander', 'Lancer', 'Mirage', 'Space Star', 'Montero', 'Colt'],
            'Suzuki' => ['Swift', 'Vitara', 'Jimny', 'Ignis', 'S-Cross', 'Baleno', 'Alto', 'Celerio', 'Ertiga', 'Ciaz', 'Spacia', 'Grand Vitara'],
            'Isuzu' => ['D-Max', 'MU-X', 'NLR', 'NMR', 'NHR', 'NQR', 'NPR', 'FSR', 'FVR', 'FTR', 'FRR', 'ELF'],
            'Ssangyong' => ['Tivoli', 'Korando', 'Rexton', 'Actyon', 'XLV', 'Musso', 'Rodius', 'Kyron', 'Chairman', 'Stavic', 'Tivoli XLV', 'Rexton Sports'],
            'Jeep' => ['Compass', 'Renegade', 'Grand Cherokee', 'Wrangler', 'Cherokee', 'Commander', 'Gladiator', 'Patriot', 'Liberty', 'Avenger', 'Willys', 'Wagoneer'],
            'MG' => ['ZS', 'HS', 'MG5', 'GS', 'MG3', 'RX5', 'MG6', 'EHS', 'GT', 'Marvel R', 'MG4', 'Cyberster'],
            'BYD' => ['Han', 'Tang', 'Song', 'Yuan', 'Seal', 'Dolphin', 'Atto 3', 'S6', 'F3', 'G3', 'S7', 'F0'],
            'Chery' => ['Tiggo 2', 'Tiggo 3', 'Tiggo 4', 'Tiggo 5', 'Tiggo 7', 'Tiggo 8', 'Arrizo 5', 'Arrizo 6', 'QQ', 'Fulwin', 'Exeed TXL', 'Exeed VX'],
            'Haval' => ['H2', 'H6', 'Jolion', 'H9', 'Big Dog', 'F7', 'F7x', 'M6', 'H7', 'H5', 'H1', 'H4'],
            'Great Wall' => ['Hover', 'Wingle', 'Poer', 'Steed', 'Cannon', 'V240', 'H5', 'H3', 'H6', 'M4', 'C30', 'Voleex C10'],
            'Geely' => ['Emgrand', 'Coolray', 'Azkarra', 'Okavango', 'GC6', 'GX7', 'Icon', 'Tugella', 'Boyue', 'Binrui', 'Monjaro', 'Atlas'],
            'JAC' => ['S2', 'S3', 'S4', 'S5', 'T6', 'T8', 'J4', 'J5', 'M3', 'M5', 'iEV7S', 'E-S4'],
            'Mahindra' => ['XUV500', 'XUV300', 'Scorpio', 'Bolero', 'KUV100', 'XUV700', 'Thar', 'TUV300', 'Marazzo', 'Alturas G4', 'Quanto', 'Verito'],
            'DFSK' => ['Glory 500', 'Glory 580', 'Glory 330', 'Glory 360', 'C35', 'C37', 'K01', 'K02', 'F5', 'F7', 'C31', 'C32'],
            'Land Rover' => ['Range Rover', 'Range Rover Sport', 'Range Rover Evoque', 'Discovery', 'Discovery Sport', 'Defender', 'Velar', 'Freelander', 'Range Rover Vogue', 'Range Rover Autobiography', 'Range Rover HSE', 'Range Rover SV'],
            'Porsche' => ['Cayenne', 'Macan', 'Panamera', '911', 'Taycan', '718 Boxster', '718 Cayman', '918 Spyder', 'Carrera GT', 'Panamera Sport Turismo', 'Cayenne Coupé', 'Macan T'],
            'Volvo' => ['XC40', 'XC60', 'XC90', 'S60', 'S90', 'V40', 'V60', 'V90', 'C30', 'C40', 'S40', 'V50'],
            'Alfa Romeo' => ['Giulia', 'Stelvio', 'Giulietta', 'MiTo', '4C', 'Tonale', 'Brera', '159', '147', 'Spider', 'GT', '8C Competizione'],
            'Mini' => ['Cooper', 'Countryman', 'Clubman', 'Paceman', 'John Cooper Works', 'Cabrio', 'Roadster', 'Coupé', 'Electric', 'Convertible', 'One', '5-Door']
        ];
        foreach ($makers as $maker => $models) {
            Maker::factory()
                ->state(['name' => $maker])
                ->has(
                    Model::factory()
                        ->count(count($models))
                        ->sequence(...array_map(fn($model) => ['name' => $model], $models))
                )
                ->create();
        }


        // Create users, cars with images and features
        // Create 3 users first, then create 2 more users,
        // and for each user (from the last 2 users) create 50 cars,
        // with images and features and add these cars to favourite cars
        // of these 2 users.

        User::factory()
            ->count(3)
            ->create();

        User::factory()
            ->count(2)
            ->has(
                Car::factory()
                    ->count(50)
                    ->has(
                        CarImage::factory()
                            ->count(5)
                            ->sequence(fn(Sequence $sequence) => ['position' => $sequence->index % 5 + 1]),
                        'images'
                    )
                    ->hasFeatures(),
                'favouriteCars'
            )
            ->create();
    }
}
