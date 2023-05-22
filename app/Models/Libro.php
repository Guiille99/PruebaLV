<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    public function pedidos(){
        return $this->belongsToMany(Pedido::class)->withPivot("precio", "cantidad", "subtotal");
    }

    public function carritos(){
        return $this->hasMany(Carrito::class);
    }

    public function items(){
        return $this->hasMany(CarritoLibro::class);
    }

    public function wishlistItems(){
        return $this->hasMany(WishListLibro::class);
    }
}
