<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Specify the table name if it's not pluralized

    // Specify the fillable attributes
    protected $fillable = [
        'id_anggota',
        'tipe_transaksi',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
    ];
}
