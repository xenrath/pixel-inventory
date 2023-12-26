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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier')->nullable();
            $table->string('nama_supp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('hp')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('norek')->nullable();
            $table->string('tanggal_awal')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};