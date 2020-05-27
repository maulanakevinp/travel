<?php

use App\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'user_id'           => 2,
            'package_id'        => 1,
            'transaction_id'    => 851420,
            'via'               => 'qris',
            'channel'           => 'linkaja',
            'total'             => '12499',
            'payment_no'         => 'asdflahaleuorhalskjdfhlaksjfh',
            'expired'           => '2020-05-22 21:28:20',
            'status'            => 'pending',
            'asal'              => 'Bondowoso',
            'qty'               => 2,
            'tanggal_berangkat' => '2020-05-23 09:28:20',
            'tanggal_pulang'    => '2020-05-23 21:28:20',
            'rating'            => 5,
            'testimoni'         => 'Perjalanan nyaman wisatanya indah'
        ]);
    }
}
