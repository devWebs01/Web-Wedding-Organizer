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
            ['name' => 'Semua Kategori'],
            ['name' => 'Aksesori Pernikahan'],
            ['name' => 'Boutonnieres & Corsages'],
            ['name' => 'Bridal'],
            ['name' => 'Bulan madu'],
            ['name' => 'Bunga'],
            ['name' => 'Busana Pria'],
            ['name' => 'Dekorasi & Pencahayaan'],
            ['name' => 'Entertainment (DJ)'],
            ['name' => 'Entertainment (MC)'],
            ['name' => 'Entertainment (Musik)'],
            ['name' => 'Fotografi'],
            ['name' => 'Gaun & Busana Pengantin'],
            ['name' => 'Hair & Makeup'],
            ['name' => 'Katering'],
            ['name' => 'Kesehatan & Kecantikan'],
            ['name' => 'Kue Pengantin'],
            ['name' => 'Layanan Unik'],
            ['name' => 'Officiant'],
            ['name' => 'Perhiasan'],
            ['name' => 'Photo booth'],
            ['name' => 'Rental'],
            ['name' => 'Sepatu Pengantin'],
            ['name' => 'Suvenir & Hadiah'],
            ['name' => 'Sweet Corner'],
            ['name' => 'Tari & Koreografi'],
            ['name' => 'Undangan'],
            ['name' => 'Venue'],
            ['name' => 'Videografi'],
            ['name' => 'Wedding Planner'],
        ];

        foreach ($categories as $category) {
            Category::insert($category);
        }
    }

}
