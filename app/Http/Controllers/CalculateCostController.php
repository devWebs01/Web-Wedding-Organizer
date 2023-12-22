<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use Illuminate\Support\Facades\Http;

class CalculateCostController extends Controller
{
    public function index()
    {

        // $destination = Address::where('user_id', auth()->id())->first()->city_id;
        // $origin = Shop::first()->city_id;
        // $weight = 111;

        // $response = Http::asForm()->withHeaders([
        //     'content-type' => 'application/x-www-form-urlencoded',
        //     'key' => 'b516c217722f0c12ba812e4129070d5f',
        // ])->post('https://api.rajaongkir.com/starter/cost', [
        //     'origin' => $origin,
        //     'destination' => $destination,
        //     'weight' => $weight,
        //     'courier' => 'jne',
        // ]);

        // $results = $response['rajaongkir']['results'];

        // foreach ($results as $result) {
        //     $service = $result['code'];
        //     $description = $result['name'];

        //     foreach ($result['costs'] as $cost) {
        //         $layanan = $cost['service'];
        //         $value = $cost['cost'][0]['value'];  // Asumsikan hanya mengambil biaya pertama
        //         $etd = $cost['cost'][0]['etd'];

        //         // Lakukan pemrosesan lebih lanjut dengan data yang diperoleh
        //         echo "Service: $service, Description: $description, Layanan: $layanan, Value: $value, ETD: $etd\n";
        //     }
        // }
        $order = Order::find(1);

        $jneShippingData = [
            'origin'      => Address::where('user_id', auth()->id())->first()->city_id,
            'destination' => Shop::first()->city_id,
            'weight'      => $order->total_weight,
            'courier'     => RajaongkirCourier::JNE,
        ];
        $tikiShippingData = [
            'origin'      => Address::where('user_id', auth()->id())->first()->city_id,
            'destination' => Shop::first()->city_id,
            'weight'      => $order->total_weight,
            'courier'     => RajaongkirCourier::TIKI,
        ];

        $jneOngkirCost = \Rajaongkir::getOngkirCost(
            $jneShippingData['origin'],
            $jneShippingData['destination'],
            $jneShippingData['weight'],
            $jneShippingData['courier']
        );

        $tikiOngkirCost = \Rajaongkir::getOngkirCost(
            $tikiShippingData['origin'],
            $tikiShippingData['destination'],
            $tikiShippingData['weight'],
            $tikiShippingData['courier']
        );

        $jneShippingCost = $jneOngkirCost[0]['costs'];  // Asumsikan hanya terdapat satu hasil kurir
        $tikiShippingCost = $tikiOngkirCost[0]['costs'];

        $combinedShippingCosts = array_merge($jneShippingCost, $tikiShippingCost);

        $selectOptions = [];
        foreach ($combinedShippingCosts as $shippingCost) {
            $selectOptions[] = [
                'description' => $shippingCost['description'],
                'value' => $shippingCost['cost'][0]['value'],
                'etd' => $shippingCost['cost'][0]['etd'],
            ];
        }

        // dd($selectOptions);
        // foreach ($jneShippingCost as $result_JNE) {
        //     $service = $result_JNE['service'];  // Kode layanan (misal: OKE, REG)
        //     $description = $result_JNE['description'];  // Deskripsi layanan

        //     // Akses array `cost` untuk mendapatkan nilai biaya dan estimasi waktu
        //     $value = $result_JNE['cost'][0]['value'];  // Nilai biaya kirim
        //     $etd = $result_JNE['cost'][0]['etd'];  // Estimasi waktu pengiriman

        //     // Lakukan pemrosesan lebih lanjut dengan data yang diperoleh
        //     echo "Service: $service, Description: $description, Value: $value, ETD: $etd\n";
        // }
        // foreach ($tikiShippingCost as $result_TIKI) {
        //     $service = $result_TIKI['service'];  // Kode layanan (misal: OKE, REG)
        //     $description = $result_TIKI['description'];  // Deskripsi layanan

        //     // Akses array `cost` untuk mendapatkan nilai biaya dan estimasi waktu
        //     $value = $result_TIKI['cost'][0]['value'];  // Nilai biaya kirim
        //     $etd = $result_TIKI['cost'][0]['etd'];  // Estimasi waktu pengiriman

        //     // Lakukan pemrosesan lebih lanjut dengan data yang diperoleh
        //     echo "Service: $service, Description: $description, Value: $value, ETD: $etd\n";
        // }

        return view('testing.index', [
            'selectOptions' => $selectOptions,
        ]);
    }
}
