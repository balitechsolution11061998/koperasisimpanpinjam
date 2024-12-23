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
        Schema::create('dividen', function (Blueprint $table) {
            $table->id('id_dividen');
            $table->integer('tahun');
            $table->decimal('jumlah_dividen', 15, 2);
            $table->date('tanggal_pembagian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividen');
    }
};
