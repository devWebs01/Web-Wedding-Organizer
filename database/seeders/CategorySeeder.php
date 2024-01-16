<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pewangi Laundry Cair',
            ],
            [
                'name' => 'Pewangi Laundry Bubuk',
            ],
            [
                'name' => 'Pewangi Laundry Gel',
            ],
            [
                'name' => 'Pewangi Laundry Botol 500ml',
            ],
            [
                'name' => 'Pewangi Laundry Botol 1000ml',
            ],
            [
                'name' => 'Pewangi Laundry Sachet',
            ],
            [
                "name" => "Pewangi Laundry Softener",
            ],
            [
                "name" => "Pewangi Laundry Anti Bakteri",
            ],
            [
                "name" => "Pewangi Laundry Wangi Alami",
            ],
            [
                "name" => "Pewangi Laundry Wangi Bunga",
            ],
            [
                "name" => "Pewangi Laundry Wangi Buah",
            ],
            [
                "name" => "Pewangi Laundry Wangi Unik",
            ],
        ];

        foreach ($categories as $category) {
            Category::insert($category);
        }
    }
}
