<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = 'pengeluaran'; // Ensure this matches the table name
    protected $fillable = ['keterangan', 'jumlah', 'tanggal']; // Add fillable fields
}
