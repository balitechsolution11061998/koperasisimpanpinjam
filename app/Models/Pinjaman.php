<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman'; // Specify the table name if it's not the plural of the model name
    protected $primaryKey = 'id_pinjaman'; // Specify the primary key

    protected $fillable = [
        'id_anggota',
        'jumlah',
        'bunga',
        'tanggal_ajukan',
        'tanggal_pencairan',
        'status',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }
}
