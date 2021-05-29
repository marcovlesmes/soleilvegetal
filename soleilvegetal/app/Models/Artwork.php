<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    public function autor() {
        return $this->belongsToMany(Autor::class);
    }

    public function technique() {
        return $this->belongsToMany(Technique::class);
    }

    public function image() {
        return $this->hasMany(Image::class);
    }
}
