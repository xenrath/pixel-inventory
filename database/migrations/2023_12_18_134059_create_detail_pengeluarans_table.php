<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengeluaran_id')->nullable();
            $table->foreign('pengeluaran_id')->references('id')->on('pengeluarans')->onDelete('set null');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('harga_pcs')->nullable();
            $table->string('harga_dus')->nullable();
            $table->string('satuan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengeluarans');
    }
};