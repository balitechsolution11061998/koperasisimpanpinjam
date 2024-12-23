<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan'; // Specify the table name if it's not pluralized

    // Specify the fillable attributes
    protected $fillable = [
        'sumber', // Add the sumber field
        'jumlah', // Amount of income
        'tanggal', // Date of income
    ];
}
