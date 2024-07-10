<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
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
        $data =
            [
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2022/11/MNK09138-600x750.jpg",
                    "title" => "W.Essentiéls x One Piece Trafalgar Law Oversize Cardigan Knitwear Black/Animal",
                    "price" => "149667",
                    "category_id" => 1,
                    "weight" => "700",
                    "description" => "Cardigan oversized ini menghadirkan gaya yang unik dengan motif hewan yang terinspirasi dari karakter One Piece Trafalgar Law. Terbuat dari bahan rajut berkualitas tinggi, cardigan ini memberikan kenyamanan maksimal saat dipakai. Dengan potongan longgar dan desain yang menarik, cardigan ini menjadi pilihan yang sempurna untuk menambahkan sentuhan kreatif pada penampilan kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2021/11/Ecume-Monopack-Noir-Depan-600x750.jpg",
                    "title" => "W.Essentiéls Ecume Monopack Oversize Hoodie Noir Black",
                    "price" => "163000",
                    "category_id" => 1,
                    "weight" => "500",
                    "description" => "Hoodie oversized ini hadir dengan desain monopack yang simpel dan elegan. Terbuat dari bahan berkualitas tinggi, hoodie ini memberikan kenyamanan maksimal saat digunakan. Dengan warna hitam yang klasik dan potongan yang longgar, hoodie ini cocok untuk gaya kasual sehari-hari atau untuk menambahkan lapisan pada outfit streetwear kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2021/11/Ecume-Misty-Grey-Depan-600x750.jpg",
                    "title" => "W.Essentiéls Ecume Oversize Hoodie Misty Grey",
                    "price" => "163000",
                    "category_id" => 1,
                    "weight" => "500",
                    "description" => "Hoodie oversized ini hadir dengan warna abu-abu misty yang menawan. Terbuat dari bahan yang nyaman dan stylish, hoodie ini memberikan kenyamanan optimal dan cocok untuk berbagai gaya. Dengan desain yang longgar, hoodie ini sempurna untuk layering dan menambahkan dimensi baru pada penampilan kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2022/11/WRM04802-600x750.jpg",
                    "title" => "W.Essentiéls x One Piece Mugiwara Flag Collegiate Varsity Jacket Noir Black/Sand",
                    "price" => "316333",
                    "category_id" => 1,
                    "weight" => "800",
                    "description" => "Jaket varsity collegiate ini adalah hasil kolaborasi antara W.Essentiels dan One Piece dengan motif bendera Mugiwara. Didesain dengan gaya sporty dan branding tim yang menonjol, jaket ini cocok untuk menambahkan sentuhan trendi pada penampilan kamu. Terbuat dari bahan berkualitas tinggi, jaket ini juga memberikan kenyamanan dan kehangatan ekstra saat dipakai."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2021/11/Ecume-Olive-Depan-600x750.jpg",
                    "title" => "W.Essentiéls Ecume Oversize Hoodie Olive",
                    "price" => "163000",
                    "category_id" => 1,
                    "weight" => "500",
                    "description" => "Hoodie oversized ini hadir dengan warna hijau zaitun yang unik dan stylish. Terbuat dari bahan berkualitas tinggi, hoodie ini memberikan kenyamanan maksimal saat digunakan. Cocok untuk melengkapi gaya streetwear kamu, hoodie ini menjadi pilihan yang sempurna untuk menambahkan sentuhan warna pada koleksi pakaian kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2022/11/MNK09149-600x750.jpg",
                    "title" => "W.Essentiéls x One Piece Strawhat Crew Oversize Hoodie Jacket Noir Black",
                    "price" => "183000",
                    "category_id" => 1,
                    "weight" => "600",
                    "description" => "Jaket hoodie oversized ini merupakan hasil kolaborasi antara W.Essentiels dan One Piece dengan motif kru Topi Jerami. Dibuat dengan desain yang unik dan stylish, jaket ini membawa logo tim untuk tampilan yang trendi dan menarik. Terbuat dari bahan berkualitas tinggi, jaket ini tidak hanya memberikan gaya yang luar biasa tetapi juga kenyamanan yang optimal saat dipakai."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/10/AGS05307cc-600x750.jpg",
                    "title" => "W.Essentiels x EVOS Perry Barr Official Stadium Jacket Half Zip",
                    "price" => "176333",
                    "category_id" => 1,
                    "weight" => "600",
                    "description" => "Jaket stadium resmi ini adalah hasil kolaborasi antara W.Essentiels dan EVOS Perry Barr. Dengan desain half-zip dan branding tim yang mencolok, jaket ini memberikan tampilan yang sporty dan stylish. Terbuat dari bahan berkualitas tinggi, jaket ini memberikan kenyamanan dan kehangatan saat digunakan, menjadikannya pilihan yang sempurna untuk menonjol dalam gaya kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2021/11/Ecume-Monopack-Olive-Depan-600x750.jpg",
                    "title" => "W.Essentiéls Ecume Monopack Oversize Hoodie Olive",
                    "price" => "163000",
                    "category_id" => 1,
                    "weight" => "500",
                    "description" => "Hoodie oversized ini hadir dengan warna hijau zaitun yang menawan dan desain monopack yang simpel dan elegan. Terbuat dari bahan berkualitas tinggi, hoodie ini memberikan kenyamanan maksimal saat digunakan. Cocok untuk gaya kasual sehari-hari, hoodie ini adalah pilihan yang sempurna untuk menambah gaya pada koleksi pakaian kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2022/11/MNK09146-600x750.jpg",
                    "title" => "W.Essentiéls x One Piece Tony Tony Chopper Oversize Hoodie North Carolina",
                    "price" => "183000",
                    "category_id" => 1,
                    "weight" => "600",
                    "description" => "Jaket hoodie oversized ini adalah hasil kolaborasi antara W.Essentiels dan One Piece dengan motif Tony Tony Chopper. Didesain dengan desain yang unik dan stylish, jaket ini membawa logo tim untuk tampilan yang trendi dan menarik. Terbuat dari bahan berkualitas tinggi, jaket ini memberikan kenyamanan maksimal dan cocok untuk menambah sentuhan warna pada penampilan streetwear kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/11/IMG_5959cc-600x750.jpg",
                    "title" => "W.Essentiels X One Piece Kaido Button up Shirt Black",
                    "price" => "149667",
                    "category_id" => 1,
                    "weight" => "400",
                    "description" => "Kemeja button-up ini hadir dengan warna hitam yang klasik dan motif Kaido dari One Piece. Didesain dengan gaya yang unik dan stylish, kemeja ini adalah pilihan yang sempurna untuk melengkapi gaya streetwear kamu. Terbuat dari bahan berkualitas tinggi, kemeja ini memberikan kenyamanan maksimal saat digunakan."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2024/05/SS24-26-600x750.jpg",
                    "title" => "W.Essentiels Therain 201 Baggy Pants Military Green",
                    "price" => "479000",
                    "category_id" => 2,
                    "weight" => "800",
                    "description" => "Celana baggy Therain 201 adalah model longgar yang dirancang untuk memberikan tampilan stylish dan nyaman sepanjang hari. Dengan warna hijau militer yang khas, celana ini cocok untuk gaya streetwear serta berbagai aktivitas sehari-hari. Terbuat dari bahan berkualitas tinggi, celana ini menawarkan kombinasi sempurna antara gaya dan fungsionalitas."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2024/05/SS24-19-600x750.jpg",
                    "title" => "W.Essentiels Type 301 Half-zip Overshirt Olive",
                    "price" => "359000",
                    "category_id" => 1,
                    "weight" => "700",
                    "description" => "Overshirt half-zip model Type 301 hadir dengan desain yang stylish dan fungsional. Dengan warna hijau zaitun yang klasik, overshirt ini cocok untuk layering dan berbagai gaya. Terbuat dari bahan berkualitas tinggi, overshirt ini memberikan kenyamanan dan penampilan yang menarik sepanjang hari."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/09/AGS03863-600x750.jpg",
                    "title" => "W.Essentiéls Bergheim 6 Pockets Cargo Sand",
                    "price" => "599000",
                    "category_id" => 2,
                    "weight" => "1000",
                    "description" => "Celana cargo Bergheim dengan model 6 kantong adalah pilihan yang tepat untuk gaya streetwear yang trendi dan fungsional. Dengan warna pasir yang elegan, celana ini tidak hanya menambah gaya kamu tetapi juga memberikan kemudahan dalam menyimpan barang. Terbuat dari bahan berkualitas tinggi, celana ini dirancang untuk menemani aktivitas sehari-hari kamu dengan kenyamanan optimal."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/09/AGS03869-600x750.jpg",
                    "title" => "W.Essentiéls Bergheim 6 Pockets Cargo Noir Black",
                    "price" => "599000",
                    "category_id" => 2,
                    "weight" => "1000",
                    "description" => "Celana cargo Bergheim dengan model 6 kantong adalah pilihan yang tepat untuk gaya streetwear yang trendi dan fungsional. Dengan warna hitam yang klasik, celana ini tidak hanya menambah gaya kamu tetapi juga memberikan kemudahan dalam menyimpan barang. Terbuat dari bahan berkualitas tinggi, celana ini dirancang untuk menemani aktivitas sehari-hari kamu dengan kenyamanan optimal."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2021/11/IMG_8292cc-600x750.jpg",
                    "title" => "Water The Plant Shroom Dunk Monochrome",
                    "price" => "1999000",
                    "category_id" => 3,
                    "weight" => "500",
                    "description" => "Sepatu sneakers model dunk dengan motif shroom yang unik dan stylish. Cocok untuk gaya streetwear dan aktivitas sehari-hari."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/12/vans_vans_classic_slip-on_-_flame_skull_black-true_white_-vn0009q7bmx-_full02_ciuo96yh-600x750.jpg",
                    "title" => "Vans Classic Slip-On Flame Skull Black/True White",
                    "price" => "1099000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu slip-on Vans Classic dengan motif flame skull yang keren dan berani. Cocok untuk melengkapi gaya streetwear kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2024/02/VN0007NC_1KP_ALT3-600x750.jpg",
                    "title" => "Vans Slip-On VR3 Checkerboard Black Marshmallow",
                    "price" => "1399000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu slip-on Vans VR3 dengan motif checkerboard hitam dan marshmallow yang klasik dan stylish. Cocok untuk berbagai gaya dan aktivitas."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/12/vans_vans_authentic_-_vans_logo_shadow-true_white_-vn0009pvxn7-_full02_u0xfb6n3-600x750.jpg",
                    "title" => "Vans Authentic Logo Shadow/True White",
                    "price" => "999000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Authentic dengan logo Vans yang ikonik dengan efek shadow. Cocok untuk gaya kasual dan sehari-hari."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/10/VN0009PV_448_ALT2-600x750.jpg",
                    "title" => "Vans Authentic Disney 100 OG Family Multi",
                    "price" => "1499000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Authentic edisi khusus Disney 100 dengan motif karakter Disney yang unik dan menarik."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/10/VN0005UF_BMB_ALT1-600x750.jpg",
                    "title" => "Vans Old Skool Disney 100 Scrapbook Multi",
                    "price" => "1699000",
                    "category_id" => 3,
                    "weight" => "500",
                    "description" => "Sepatu low-top Vans Old Skool edisi khusus Disney 100 dengan motif scrapbook yang penuh warna dan menarik."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/10/VN000BW7_BMB_HERO-600x750.jpg",
                    "title" => "Vans SK8 Hi Disney 100 Villain Multi",
                    "price" => "1599000",
                    "category_id" => 3,
                    "weight" => "600",
                    "description" => "Sepatu high-top Vans SK8 Hi edisi khusus Disney 100 dengan motif karakter villain Disney yang unik dan keren."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/10/VN0A3MUS6BT-1-600x750.jpg",
                    "title" => "Vans Old Skool Mule Black/True White",
                    "price" => "1099000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu mule Vans Old Skool dengan warna hitam dan putih yang klasik dan nyaman. Cocok untuk gaya kasual dan sehari-hari."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/07/Old-Skool-Canvas-BW-2-600x750.jpg",
                    "title" => "Vans Old Skool (Canvas) Black / True White",
                    "price" => "1099000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Old Skool klasik dengan bahan canvas dan warna hitam dan putih yang timeless."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/07/VN0009PVBP6-ALT2-600x750.jpeg",
                    "title" => "Vans Authentic Leopard Black True White",
                    "price" => "999000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Authentic dengan motif leopard yang stylish dan berani. Cocok untuk melengkapi gaya streetwear kamu."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/07/VN000BW3_BKC_HERO-600x750.jpg",
                    "title" => "Vans Classic Slip-On 138 Sidestripe Black Checkerboard",
                    "price" => "1199000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu slip-on Vans Classic dengan motif sidestripe dan checkerboard yang ikonik. Cocok untuk gaya kasual dan sehari-hari."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/06/VN0009PVYLW-ALT4-1-600x750.jpeg",
                    "title" => "Vans Authentic Sesame Street Yellow",
                    "price" => "1299000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Authentic edisi khusus Sesame Street dengan warna kuning yang cerah dan menarik."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/06/VN000EE3BK2-1_1200x1200-600x750.jpg",
                    "title" => "Vans Authentic Sesame Street Yellow/Multi",
                    "price" => "1499000",
                    "category_id" => 3,
                    "weight" => "400",
                    "description" => "Sepatu low-top Vans Authentic edisi khusus Sesame Street dengan warna kuning dan motif karakter Sesame Street yang unik."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/09/AGS04027-600x750.jpg",
                    "title" => "W.Essentiels Cam Ref-31 Twill Cargo Baloon Pants Olive Green",
                    "price" => "579000",
                    "category_id" => 2,
                    "weight" => "900",
                    "description" => "Celana cargo balon Cam Ref-31 Twill adalah pilihan yang sempurna untuk menambah gaya streetwear kamu. Dengan warna hijau zaitun yang stylish dan nyaman, celana ini cocok untuk berbagai aktivitas sehari-hari. Terbuat dari bahan berkualitas tinggi, celana ini memberikan kenyamanan maksimal tanpa mengorbankan gaya."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/09/AGS04033-600x750.jpg",
                    "title" => "W.Essentiels Cam Ref-31 Twill Cargo Baloon Pants Noir Black",
                    "price" => "579000",
                    "category_id" => 2,
                    "weight" => "900",
                    "description" => "Celana cargo balon Cam Ref-31 Twill adalah pilihan yang sempurna untuk menambah gaya streetwear kamu. Dengan warna hitam yang klasik dan nyaman, celana ini cocok untuk berbagai aktivitas sehari-hari. Terbuat dari bahan berkualitas tinggi, celana ini memberikan kenyamanan maksimal tanpa mengorbankan gaya."
                ],
                [
                    "image" => "https://www.wormholestore.com/wp-content/uploads/2023/09/AGS03846-600x750.jpg",
                    "title" => "W.Essentiels Martigues Relaxed Sweat Short Camel",
                    "price" => "399000",
                    "category_id" => 2,
                    "weight" => "500",
                    "description" => "Celana pendek sweat Martigues dengan model relaxed fit hadir dengan warna camel yang klasik. Cocok untuk gaya kasual dan aktivitas santai, celana ini memberikan kenyamanan maksimal dan penampilan yang menarik. Terbuat dari bahan berkualitas tinggi, celana ini adalah pilihan yang sempurna untuk menambah koleksi pakaian santai kamu."
                ],



            ];
        foreach ($data as $item) {
            // Upload gambar dari URL ke folder storage
            $imageContents = file_get_contents($item['image']);
            $imageName = basename($item['image']);
            $storagePath = 'images/' . $imageName;
            Storage::disk('public')->put($storagePath, $imageContents);

            // Buat record produk di database
            $product = Product::create([
                'category_id' => $item['category_id'],
                'title' => $item['title'],
                'price' => $item['price'],
                'quantity' => 0,
                'image' => $storagePath,
                'weight' => $item['weight'],
                'description' => $item['description'],
            ]);

            $this->command->info('Tambah Produk ' . $product->title);
        }
    }
}
