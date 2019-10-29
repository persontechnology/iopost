<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaestriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maestrias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('tipoPrograma');
            $table->string('campoAmplio',255);
            $table->string('campoEspecifico',255);
            $table->string('campoDetallado');
            $table->string('campoAmplio');
            $table->string('programa');
            $table->string('titulo');
            $table->integer('codificacionPrograma');
            $table->string('lugarEjecucion',255);
            $table->string('duracion');
            $table->string('tipoPeriodo');
            $table->integer('numerHoras');
            $table->string('resolucion');
            $table->date('fechaResolucion');
            $table->string('campoAmplio');
            $table->string('modalidad');
            $table->string('paralelos');
            $table->string('vigencia');
            $table->date('fechaAprobacion');
            $table->intger('capacidaParalelo');
            $table->timestamps();
              $table->bigInteger('usuarioCreado')->nullable();
            $table->bigInteger('usuarioActualizado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maestrias');
    }
}
