<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function artwork() {
        return $this->belongsTo(Artwork::class);
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
