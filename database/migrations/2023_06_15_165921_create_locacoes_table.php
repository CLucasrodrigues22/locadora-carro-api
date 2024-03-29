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
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('carro_id');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->dateTime('data_inicio_periodo');
            $table->dateTime('data_final_previsto_periodo');
            $table->dateTime('data_final_realizado_periodo')->nullable();
            $table->integer('total_dias_locacao')->nullable();
            $table->float('valor_diaria', 8, 2);
            $table->integer('km_inicial');
            $table->integer('km_final')->nullable();
            $table->integer('km_percorrido')->nullable();
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('carro_id')->references('id')->on('carros');
            $table->foreign('status_id')->references('id')->on('statusLocacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locacaos');
    }
};
