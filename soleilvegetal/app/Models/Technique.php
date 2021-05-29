<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
    use HasFactory;

    public function artwork() {
        return $this->belongsToMany(Artwork::class);
    }
}
