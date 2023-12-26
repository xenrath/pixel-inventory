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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('kode_user')->nullable();;
            $table->string('nama')->nullable();;
            $table->string('telp')->nullable();;
            $table->string('alamat')->nullable();;
            $table->string('username')->unique();
            $table->string('password')->nullable();;
            $table->string('gambar')->nullable();;
            $table->enum('role', ['admin', 'sales']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};