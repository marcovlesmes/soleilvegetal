<?php

namespace Database\Factories;

use App\Models\Artwork;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'artwork_id' => Artwork::class,
            'image_source' => $this->faker->imageUrl(640, 480, 'art'),
            'priority' => $this->faker->randomDigit()
        ];
    }
}
