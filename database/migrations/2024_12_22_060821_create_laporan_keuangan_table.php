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
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('total_pendapatan', 15, 2);
            $table->decimal('total_pengeluaran', 15, 2);
            $table->decimal('laba_rugi', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};
