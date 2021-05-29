<?php

namespace Database\Factories;

use App\Models\Artwork;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artwork::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(asText: true),
            'year' => $this->faker->numberBetween(1900, 2012),
            'format' => $this->faker->randomNumber(2, true) . ' x ' . $this->faker->randomNumber(2, true),
            'edition' => $this->faker->randomNumber(2, true) . ' copias',
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(5000000, 500000000)
        ];
    }
}
