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
                'image' => 'https://alexandra.bridestory.com/image/upload/dpr_1.0,f_webp,fl_progressive,q_80,c_fill,g_faces,w_600/assets/upload-cp1q-LVhn.webp',
                'price' => 7000000,
                'description' => 'Dimulai dari IDR 7.000.000 / 5-6 jam, Termasuk: Full Band (2 Penyanyi, Saxophone, Gitar, Bass, Drum & Keyboard), Soundsystem & Crew',
            ],
            [
                'category_id' => 2,
                'title' => 'Lite Orchestra Package',
                'image' => 'https://alexandra.bridestory.com/image/upload/dpr_1.0,f_webp,fl_progressive,q_80,c_fill,g_faces,w_600/assets/upload--ge-105xa.webp',
                'price' => 10000000,
                'description' => 'Dimulai dari IDR 10.000.000 / 5-6 jam, Termasuk: Lite Orchestra (Violins, Violas, Violoncellos), Full Band, Soundsystem & Crew',
            ],
            [
                'category_id' => 3,
                'title' => 'Prewedding Photography - Premium Package',
                'image' => 'https://i.pinimg.com/1200x/8b/eb/dd/8bebdde7436dbfb9b6e950d41502b122.jpg',
                'price' => 9090000,
                'description' => '1 Hari Photoshoot, 1 Magazine Photobook 20x30 (50 halaman), 1 Frame Canvas Photo 50x75 (Premium), 1 Frame Crystal Photo 50x75 (Premium), 60 Edited Photo High Resolution, CD semua file',
            ],
            [
                'category_id' => 3,
                'title' => 'Wedding Day Photography Package',
                'image' => 'https://i.pinimg.com/1200x/a1/58/1e/a1581efb174be4115ec01bcca8a1d7d9.jpg',
                'price' => 9090000,
                'description' => '2 Fotografer, 1 Magazine Photobook 30x30 Premium, 2 Frame Canvas Photo 50x75, CD semua file',
            ],
            [
                'category_id' => 3,
                'title' => 'Wedding Coverage Photography',
                'image' => 'https://i.pinimg.com/1200x/cb/38/77/cb387711cc7c289f21886f47ff7ab263.jpg',
                'price' => 5800000,
                'description' => 'Dimulai dari IDR 5.800.000 / Paket, Liputan Akad + Resepsi, 1 fotografer Utama, 1 Fotografer Candid, 1 Videografer, 1 Crew',
            ],
            [
                'category_id' => 3,
                'title' => 'Outdoor Prewedding Photography',
                'image' => 'https://i.pinimg.com/1200x/27/b4/4f/27b44f9d3ddbbfb0b37956ca78f42c7c.jpg',
                'price' => 1500000,
                'description' => 'Dimulai dari IDR 1.500.000 / Paket, 1 Day Photoshoot Max 1 Location Photo (Indoor / Outdoor)',
            ],
            [
                'category_id' => 3,
                'title' => 'Indoor Prewedding Photography Session',
                'image' => 'https://i.pinimg.com/1200x/00/4f/45/004f45292157a16e2a6084e08ad94a5b.jpg',
                'price' => 800000,
                'description' => 'Di antara IDR 800.000 hingga 1.200.000 / Paket, 1 Session Photoshoot Max 2 Hours',
            ],
            // Dekorasi & Pencahayaan
            [
                'category_id' => 1,
                'title' => 'Romantic Wedding Lighting Setup',
                'image' => 'https://i.pinimg.com/1200x/dd/ae/aa/ddaeaa1de27d3b31849ce8e788a2b06f.jpg',
                'price' => 5000000,
                'description' => 'Dekorasi lampu gantung yang romantis dengan string lights, cocok untuk resepsi outdoor atau indoor.',
            ],
            [
                'category_id' => 1,
                'title' => 'Elegant Floral Decorations',
                'image' => 'https://i.pinimg.com/1200x/83/4b/0d/834b0d37c85cfe241d9f03b949efe04c.jpg',
                'price' => 7000000,
                'description' => 'Dekorasi bunga segar dan lampu sorot untuk menciptakan suasana elegan di acara pernikahan.',
            ],

            // Gaun & Busana Pengantin
            [
                'category_id' => 4,
                'title' => 'Luxury Bridal Gown',
                'image' => 'https://i.pinimg.com/1200x/5a/48/ba/5a48bafd57aad0655e5ed8ccc31138ac.jpg',
                'price' => 15000000,
                'description' => 'Gaun pengantin mewah dengan detail renda dan kristal, dirancang khusus untuk hari istimewa.',
            ],
            [
                'category_id' => 4,
                'title' => 'Traditional Wedding Kebaya',
                'image' => 'https://i.pinimg.com/1200x/22/8a/a8/228aa802ca96940c0b45297d729d1d60.jpg',
                'price' => 12000000,
                'description' => 'Kebaya tradisional modern dengan bordir halus dan kain songket premium.',
            ],

            // Hair & Makeup
            [
                'category_id' => 5,
                'title' => 'Bridal Makeup Package',
                'image' => 'https://i.pinimg.com/1200x/de/85/47/de8547a49a6944ff689a99f7b4e39b15.jpg',
                'price' => 2500000,
                'description' => 'Paket makeup pengantin dengan look natural dan tahan lama untuk hari spesial Anda.',
            ],
            [
                'category_id' => 5,
                'title' => 'Hairdo and Styling Service',
                'image' => 'https://i.pinimg.com/1200x/34/ad/c3/34adc3c3205baf2da9df0d96ca505b96.jpg',
                'price' => 1500000,
                'description' => 'Penataan rambut untuk pengantin dan keluarga, termasuk styling modern dan tradisional.',
            ],

            // Katering
            [
                'category_id' => 6,
                'title' => 'Premium Buffet Catering',
                'image' => 'https://i.pinimg.com/1200x/bb/8a/6c/bb8a6c34935b86b9ae314069a326f787.jpg',
                'price' => 30000000,
                'description' => 'Paket katering prasmanan dengan menu internasional dan lokal untuk 200 tamu.',
            ],
            [
                'category_id' => 6,
                'title' => 'Intimate Wedding Catering',
                'image' => 'https://i.pinimg.com/1200x/12/8c/83/128c830d080584643bb030e59a738bdb.jpg',
                'price' => 15000000,
                'description' => 'Paket katering untuk pernikahan intimate dengan menu yang dapat disesuaikan.',
            ],

            // Photo Booth
            [
                'category_id' => 7,
                'title' => 'Customizable Photo Booth',
                'image' => 'https://i.pinimg.com/1200x/16/cb/9f/16cb9f83651ccde41977c68a8dc8cd0c.jpg',
                'price' => 7000000,
                'description' => 'Photo booth dengan backdrop yang dapat disesuaikan, termasuk properti foto.',
            ],
            [
                'category_id' => 7,
                'title' => 'Vintage Style Photo Booth',
                'image' => 'https://i.pinimg.com/1200x/e7/59/47/e7594775fc85d8c61a4b1f0154166560.jpg',
                'price' => 8000000,
                'description' => 'Photo booth bergaya vintage dengan filter klasik dan pencahayaan retro.',
            ],

            // Rental
            [
                'category_id' => 8,
                'title' => 'Luxury Wedding Car Rental',
                'image' => 'https://i.pinimg.com/1200x/f0/89/ff/f089ffcb1839b136f41635e4a2ad3734.jpg',
                'price' => 5000000,
                'description' => 'Sewa mobil pengantin mewah seperti Rolls Royce atau Mercedes-Benz untuk hari istimewa.',
            ],
            [
                'category_id' => 8,
                'title' => 'Event Equipment Rental',
                'image' => 'https://i.pinimg.com/1200x/5d/12/82/5d128242304d269c1a4a692f4422a369.jpg',
                'price' => 2000000,
                'description' => 'Sewa perlengkapan acara seperti kursi, meja, dan sound system.',
            ],

            // Tari & Koreografi
            [
                'category_id' => 9,
                'title' => 'Traditional Dance Performance',
                'image' => 'https://i.pinimg.com/1200x/d0/15/12/d015122a6a0ddb98a20835b76f0d7553.jpg',
                'price' => 3000000,
                'description' => 'Pertunjukan tari tradisional untuk acara pernikahan dengan penari profesional.',
            ],
            [
                'category_id' => 9,
                'title' => 'Wedding Couple First Dance Choreography',
                'image' => 'https://i.pinimg.com/236x/2f/96/f3/2f96f30b8ac03412baa5a85810fd6482.jpg',
                'price' => 1500000,
                'description' => 'Koreografi tarian pertama pengantin yang romantis dan mudah diikuti.',
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
