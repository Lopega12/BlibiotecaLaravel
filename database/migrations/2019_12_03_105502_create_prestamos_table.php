<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_book');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_book')->references('id')->on('books');
            $table->foreign('id_user')->references('id')->on('users');
            $table->dateTime('date_devol')->nullable(true);
            $table->dateTime('date_prestamo');
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
        Schema::dropIfExists('prestamos');

    }
}
