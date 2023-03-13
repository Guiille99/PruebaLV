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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string("titulo");
            $table->string("autor", 100);
            $table->string("editorial", 80);
            $table->string("portada");
            $table->string("isbn", 17)->unique();
            $table->date("fecha_publicacion");
            $table->double("precio",4,2);
            $table->string("genero", 40);
            $table->text("descripcion");
            $table->double("valoracion");
            $table->integer("paginas");
            $table->integer("stock");
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
        Schema::dropIfExists('libros');
    }
};
