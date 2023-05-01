<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = "direcciones";
    public $timestamps = false;

    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot("principal");
    }
}
