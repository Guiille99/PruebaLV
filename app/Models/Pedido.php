<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function direccion(){
        return $this->belongsTo(Direccion::class);
    }

    public function libros(){
        return $this->belongsToMany(Libro::class)->withPivot("precio", "cantidad", "subtotal");
    }
}
