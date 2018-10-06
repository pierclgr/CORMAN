<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('titolo');
            $table->year('dataPubblicazione');
            $table->string('pdf')->nullable();
            $table->string('immagine')->nullable();
            $table->string('multimedia')->nullable();
            $table->string('tipo');
            $table->boolean('visibilita');
            $table->string('tags')->nullable();
            $table->string('descrizione')->nullable();
            $table->text('coautori')->nullable();
            $table->integer('idUser')->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('publications');
    }
}
