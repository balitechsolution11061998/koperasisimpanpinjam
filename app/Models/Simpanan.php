<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan';
    protected $primaryKey = 'id_simpanan';

    protected $fillable = [
        'id_anggota',
        'jenis_simpanan',
        'jumlah',
        'tanggal_simpan',
        'bunga',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    // Method to calculate total savings including interest
    public function totalSimpanan()
    {
        $total = $this->jumlah;

        if ($this->bunga) {
            $total += $this->bunga; // Add interest if it exists
        }

        return $total;
    }
}
