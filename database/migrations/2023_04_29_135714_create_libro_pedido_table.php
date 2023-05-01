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
        Schema::create('libro_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pedido_id");
            $table->unsignedBigInteger("libro_id")->nullable();
            $table->double("precio",4,2);
            $table->unsignedInteger("cantidad");
            $table->double("subtotal",4,2);
            $table->foreign("pedido_id")->references("id")->on("pedidos")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("libro_id")->references("id")->on("libros")->nullOnDelete()->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libro_pedido');
    }
};
