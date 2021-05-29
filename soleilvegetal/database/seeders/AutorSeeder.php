<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Autor;
use App\Models\Technique;
use Database\Factories\ArtworkFactory;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Autor::factory(30)
        ->has(Artwork::factory()
        ->hasTechnique()
        ->count(2)
        )
        ->create();
    }
}
