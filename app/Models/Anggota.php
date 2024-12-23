<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota'; // Specify the table name if it's not pluralized
    protected $primaryKey = 'id_anggota'; // Specify the primary key
    // Define fillable properties
    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telepon',
        'email',
        'tanggal_daftar',
        'status_keanggotaan',
    ];
}
