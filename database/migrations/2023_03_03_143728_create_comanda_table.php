<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comanda', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client');
            $table->date('data_plasare');
            $table->date('data_livrare');
            $table->float('pret_comanda',6,2);
            $table->string('adresa_livrare');
            $table->string('oras_livrare');
            $table->string('judet_livrare');
            $table->string('status');
            $table->string('metoda_plata');
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
        Schema::dropIfExists('comanda');
    }
}
