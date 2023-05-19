<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoLibro extends Model
{
    protected $table = "carrito_libros";
    use HasFactory;

    public function libro(){
        return $this->belongsTo(Libro::class);
    }
}
