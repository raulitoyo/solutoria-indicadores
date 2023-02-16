<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadors', function (Blueprint $table) {
            $table->id();
            $table->string('nombreindicador')->nullable();
            $table->string('codigoindicador')->nullable();
            $table->string('unidadmedidaindicador')->nullable();
            $table->float('valorindicador', 8, 2)->nullable();
            $table->date('fechaindicador')->nullable();
            $table->float('tiempoindicador', 8, 2)->nullable();
            $table->string('origenindicador')->nullable();
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
        Schema::dropIfExists('indicadors');
    }
}
