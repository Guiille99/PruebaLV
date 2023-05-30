<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function direcciones(){
        return $this->belongsToMany(Direccion::class)->withPivot("principal");
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    public function carrito(){
        return $this->hasOne(Carrito::class);
    }

    public function wishlist(){
        return $this->hasOne(Wishlist::class);
    }

    public function tareas(){
        return $this->hasMany(Tarea::class);
    }

    public function getDireccionPrincipal(){
        $user = User::find(Auth::user()->id);
        return $user->direcciones()->wherePivot('principal', '1')->first();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
