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
            ['name' => 'Dekorasi & Pencahayaan'],
            ['name' => 'Entertainment (Musik)'],
            ['name' => 'Fotografi & Videografi'],
            ['name' => 'Gaun & Busana Pengantin'],
            ['name' => 'Hair & Makeup'],
            ['name' => 'Katering'],
            ['name' => 'Photo booth'],
            ['name' => 'Rental'],
            ['name' => 'Tari & Koreografi'],
        ];

        foreach ($categories as $category) {
            Category::insert($category);
        }
    }

}
