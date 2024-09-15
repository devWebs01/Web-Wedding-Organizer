<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "category_id" => "9",
                "vendor" => "Abieb & Friends",
                "product" => "Music Package",
                "image" => "https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/_ard6391-small-rJ-B2E0fO/abieb-friends.webp",
                "variants" => [
                    [
                        "type" => "Silver Package",
                        "price" => "7000000",
                        "description" => "Dimulai dari IDR 7.000.000 / 5-6 jam, Termasuk: Full Band (2 Penyanyi, Saxophone, Gitar, Bass, Drum & Keyboard), Soundsystem & Crew"
                    ],
                    [
                        "type" => "Gold Package",
                        "price" => "10000000",
                        "description" => "Dimulai dari IDR 10.000.000 / 5-6 jam, Termasuk: Lite Orchestra (Violins, Violas, Violoncellos), Full Band, Soundsystem & Crew"
                    ],
                ]
            ],
            [
                "category_id" => "13",
                "vendor" => "Aldea Photography",
                "product" => "Photography Package",
                "image" => "https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/file_fd30ke/aldea-photography.webp",
                "variants" => [
                    [
                        "type" => "Prewedding Package",
                        "price" => "9090000",
                        "description" => "1 Hari Photoshoot, 1 Magazine Photobook 20x30 (50 halaman), 1 Frame Canvas Photo 50x75 (Premium), 1 Frame Crystal Photo 50x75 (Premium), 60 Edited Photo High Resolution, CD semua file"
                    ],
                    [
                        "type" => "Wedding Day Package",
                        "price" => "9090000",
                        "description" => "2 Fotografer, 1 Magazine Photobook 30x30 Premium, 2 Frame Canvas Photo 50x75, CD semua file"
                    ],
                ]
            ],
            [
                "category_id" => "11",
                "vendor" => "Doctor Photography Videography",
                "product" => "Wedding Photography Package",
                "image" => "https://london.bridestory.com/images/c_fill,dpr_1.0,f_auto,fl_progressive,h_160,pg_1,q_80,w_160/v1/assets/img_9829-ByVeImreE/doctor-photography-videography.webp",
                "variants" => [
                    [
                        "type" => "Wedding Package",
                        "price" => "5800000",
                        "description" => "Dimulai dari IDR 5.800.000 / Paket, Liputan Akad + Resepsi, 1 fotografer Utama, 1 Fotografer Candid, 1 Videografer, 1 Crew"
                    ],
                    [
                        "type" => "Prewedding Package (Outdoor)",
                        "price" => "1500000",
                        "description" => "Dimulai dari IDR 1.500.000 / Paket, 1 Day Photoshoot Max 1 Location Photo (Indoor / Outdoor)"
                    ],
                    [
                        "type" => "Prewedding Package (Indoor)",
                        "price" => "800000",
                        "description" => "Di antara IDR 800.000 hingga 1.200.000 / PAKET, 1 Session Photoshoot Max 2 Hours"
                    ],
                ]
            ],
            // Add other products similarly...
        ];

        foreach ($data as $productData) {
            // Cek apakah produk sudah ada berdasarkan vendor dan category_id
            $imageContents = file_get_contents(filename: $productData['image']);
            $imageName = basename(path: $productData['image']);
            $storagePath = 'images/' . $imageName;
            Storage::disk('public')->put($storagePath, $imageContents);

            // Simpan produk utama
            $product = Product::create([
                'category_id' => $productData['category_id'],
                'vendor' => $productData['vendor'],
                'title' => $productData['product'],
                'image' => $storagePath,
            ]);

            // Simpan varian produk
            foreach ($productData['variants'] as $variantData) {
                Variant::create([
                    'product_id' => $product->id,
                    'type' => $variantData['type'],
                    'price' => $variantData['price'],
                    'description' => $variantData['description'],
                ]);
            }

            $this->command->info(string: 'Tambah Produk ' . $product->title);
        }
    }
}
