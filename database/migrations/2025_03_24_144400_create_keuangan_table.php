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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->decimal('masuk', 15, 2); 
            $table->decimal('keluar', 15, 2); 
            $table->decimal('saldo_akhir', 15, 2); 
            $table->date('tanggal');
            $table->string('bukti')->nullable(); // File bukti transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
