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
        \App\Models\Category::factory(10)->create();
        // \App\Models\Product::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'testing',
            'email' => 'testing@testing.com',
        ]);

        $this->call([
            ProductSeeder::class,
        ]);

        Artisan::call('rajaongkir:seed');

    }
}
