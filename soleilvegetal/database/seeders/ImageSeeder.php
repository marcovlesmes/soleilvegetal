<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 60; $i++) {
            for ($j = 0; $j < 5; $j++) {
                Image::create([
                    'artwork_id' => $i,
                    'image_source' => 'images/artwork_pic_00' . $j . '.png',
                    'priority' => $j
                ]);
            }
        }
    }
}
