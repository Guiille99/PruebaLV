<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishListLibro extends Model
{
    protected $table = "wishlist_libros";
    use HasFactory;

    public function libro(){
        return $this->belongsTo(Libro::class);
    }
}
