<?php

use App\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'category_id'   => 1,
            'name'          => 'Wisata Papuma',
            'price'         => '5000',
            'description'   => 'Paket wisata papuma murah fasilitas lengkap mulai 5000'
        ]);
    }
}
