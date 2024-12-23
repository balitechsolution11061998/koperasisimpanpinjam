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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id('id_pinjaman');
            // Ubah 'id_anggota' menjadi 'id_anggota' dan pastikan merujuk ke 'id_anggota' di tabel 'anggota'
            $table->foreignId('id_anggota')->constrained('anggota', 'id_anggota')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->decimal('bunga', 5, 2);
            $table->date('tanggal_ajukan');
            $table->date('tanggal_pencairan')->nullable();
            $table->enum('status', ['Disetujui', 'Belum Disetujui', 'Diambil']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
