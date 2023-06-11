<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carte', function (Blueprint $table) {
            $table->id();
            $table->string('titlu');
            $table->string('autor');
            $table->string('isbn');
            $table->string('editura');
            $table->float('pret',6,2);
            $table->integer('an_aparitie');
            $table->integer('nr_pg');
            $table->string('tip_coperta');
            $table->string('limba');
            $table->string('dimensiune');
            $table->integer('cantitate');
            $table->string('categorie');
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
        Schema::dropIfExists('carte');
    }
}
