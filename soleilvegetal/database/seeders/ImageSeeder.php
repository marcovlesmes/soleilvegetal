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
        $g = 0;
        for ($i = 1; $i <= 60; $i++) {
            $f = ($i - 1) - $g; // First index
            for ($j = 0; $j < 5; $j++) {
                Image::create([
                    'artwork_id' => $i,
                    'image_source' => 'images/artwork_pic_00' . $j . '.png',
                    'priority' => $f + $j
                ]);
                if ($f + $j == 4) $f = -($j + 1);
            }
            if($i % 5 == 0) $g += 5;
        }
    }
}
