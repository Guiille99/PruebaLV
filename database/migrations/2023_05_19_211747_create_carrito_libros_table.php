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
        Schema::create('carrito_libros', function (Blueprint $table) {
            $table->id();
            $table->foreignId("carrito_id")->constrained("carritos")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("libro_id")->constrained("libros")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedTinyInteger("cantidad");
            $table->double("subtotal",6,2);
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
        Schema::dropIfExists('carrito_libros');
    }
};
