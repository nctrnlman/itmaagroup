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
        Schema::create('user', function (Blueprint $table) {
            $table->id('idnik');
            $table->string('nama');
            $table->string('file_foto');
            $table->string('company');
            $table->string('lokasi');
            $table->string('divisi');
            $table->string('departement');
            $table->string('section');
            $table->string('position');
            $table->string('clasifikasi');
            $table->string('atasan');
            $table->string('roster');
            $table->date('doh');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
