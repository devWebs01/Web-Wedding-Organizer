<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(10)->create();
        \App\Models\Bank::factory(3)->create();
        \App\Models\User::factory(20)->create();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
        ]);

        Artisan::call('rajaongkir:seed');

        \App\Models\Shop::create([
            'name' => 'Adinda Putri',
            'province_id' => 8,
            'city_id' => 156,
            'details' => 'Jl. Arif Rahman Hakim No.111, Simpang IV Sipin, Kec. Telanaipura, Kota Jambi, Jambi 36361',

        ]);
    }
}
