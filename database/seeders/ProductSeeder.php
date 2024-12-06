<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_id' => 2,
                'title' => 'Full Band Music Entertainment',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/_ard6391-small-rJ-B2E0fO/abieb-friends.webp',
                'price' => 7000000,
                'description' => 'Dimulai dari IDR 7.000.000 / 5-6 jam, Termasuk: Full Band (2 Penyanyi, Saxophone, Gitar, Bass, Drum & Keyboard), Soundsystem & Crew',
            ],
            [
                'category_id' => 2,
                'title' => 'Lite Orchestra Package',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/_ard6391-small-rJ-B2E0fO/abieb-friends.webp',
                'price' => 10000000,
                'description' => 'Dimulai dari IDR 10.000.000 / 5-6 jam, Termasuk: Lite Orchestra (Violins, Violas, Violoncellos), Full Band, Soundsystem & Crew',
            ],
            [
                'category_id' => 3,
                'title' => 'Prewedding Photography - Premium Package',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/file_fd30ke/aldea-photography.webp',
                'price' => 9090000,
                'description' => '1 Hari Photoshoot, 1 Magazine Photobook 20x30 (50 halaman), 1 Frame Canvas Photo 50x75 (Premium), 1 Frame Crystal Photo 50x75 (Premium), 60 Edited Photo High Resolution, CD semua file',
            ],
            [
                'category_id' => 3,
                'title' => 'Wedding Day Photography Package',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/file_fd30ke/aldea-photography.webp',
                'price' => 9090000,
                'description' => '2 Fotografer, 1 Magazine Photobook 30x30 Premium, 2 Frame Canvas Photo 50x75, CD semua file',
            ],
            [
                'category_id' => 3,
                'title' => 'Wedding Coverage Photography',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/img_9829-ByVeImreE/doctor-photography-videography.webp',
                'price' => 5800000,
                'description' => 'Dimulai dari IDR 5.800.000 / Paket, Liputan Akad + Resepsi, 1 fotografer Utama, 1 Fotografer Candid, 1 Videografer, 1 Crew',
            ],
            [
                'category_id' => 3,
                'title' => 'Outdoor Prewedding Photography',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/img_9829-ByVeImreE/doctor-photography-videography.webp',
                'price' => 1500000,
                'description' => 'Dimulai dari IDR 1.500.000 / Paket, 1 Day Photoshoot Max 1 Location Photo (Indoor / Outdoor)',
            ],
            [
                'category_id' => 3,
                'title' => 'Indoor Prewedding Photography Session',
                'image' => 'https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/img_9829-ByVeImreE/doctor-photography-videography.webp',
                'price' => 800000,
                'description' => 'Di antara IDR 800.000 hingga 1.200.000 / Paket, 1 Session Photoshoot Max 2 Hours',
            ],
        ];

        foreach ($data as $productData) {
            // Cek apakah layanan sudah ada berdasarkan vendor dan category_id
            $imageContents = file_get_contents(filename: $productData['image']);
            $imageName = basename(path: $productData['image']);
            $storagePath = 'images/'.$imageName;
            Storage::disk('public')->put($storagePath, $imageContents);

            // Simpan layanan utama
            $product = Product::create([
                'category_id' => $productData['category_id'],
                'title' => $productData['title'],
                'image' => $storagePath,
                'price' => $productData['price'],
                'description' => $productData['description'],
            ]);
            $this->command->info(string: 'Tambah Layanan '.$product->title);
        }
    }
}
