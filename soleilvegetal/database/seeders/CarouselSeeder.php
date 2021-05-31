<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('carousel')->insert([
                'image_source' => 'images/carousel_pic_00' . $i . '.png',
                'description' => '',
                'active' => true
            ]);
        }
    }
}
