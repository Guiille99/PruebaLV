<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username", 25)->unique();
            $table->string("password", 80);
            $table->string("nombre", 80);
            $table->string("apellidos", 100);
            $table->string("email")->unique();
            $table->string("avatar")->default("https://res.cloudinary.com/det0ae4ke/image/upload/v1684158473/books/avatars/1682946038-default_hhfcep.png");
            $table->string("rol", 20)->default("Usuario");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
