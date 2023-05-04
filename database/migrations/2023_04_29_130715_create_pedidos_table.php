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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            // $table->dateTime("fecha");
            $table->double("total",4,2);
            $table->string("estado", 45)->default("Pre-admisión");
            $table->string("tipo_pago", 45);
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("direccion_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->nullOnDelete()->onUpdate("cascade");
            $table->foreign("direccion_id")->references("id")->on("direcciones")->nullOnDelete()->onUpdate("cascade");
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
        Schema::dropIfExists('pedidos');
    }
};
