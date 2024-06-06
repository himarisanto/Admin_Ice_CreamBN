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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nota');
            $table->date('tanggal_transaksi');
            $table->string('type_pembayaran');
            $table->unsignedBigInteger('total_produk');
            $table->unsignedBigInteger('grand_total');
            $table->unsignedBigInteger('pembayaran')->nullable(); // Mengatur pembayaran menjadi nullable secara default
            $table->unsignedBigInteger('kembalian')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
