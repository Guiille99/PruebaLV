<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class)->withDefault(['username' => 'Usuario eliminado']);
    }

    public function direccion(){
        return $this->belongsTo(Direccion::class);
    }

    public function libros(){
        return $this->belongsToMany(Libro::class)->withPivot("precio", "cantidad", "subtotal");
    }
}
