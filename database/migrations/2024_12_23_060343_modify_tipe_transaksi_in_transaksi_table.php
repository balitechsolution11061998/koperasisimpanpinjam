<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTipeTransaksiInTransaksiTable extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('tipe_transaksi', 50)->change(); // Change the length to 50 or more
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('tipe_transaksi', 10)->change(); // Revert to the original length if needed
        });
    }
}
