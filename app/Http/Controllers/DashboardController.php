<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Pengeluran;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Calculate total members
        $totalMembers = Anggota::count();

        // Calculate total savings
        $totalSavings = Simpanan::sum('jumlah');

        // Calculate total income and format it
        $totalIncome = Pemasukan::sum('jumlah');
        $formattedTotalIncome = number_format($totalIncome, 2, ',', '.');

        // Calculate total expenses and format it
        $totalExpenses = Pengeluaran::sum('jumlah');
        $formattedTotalExpenses = number_format($totalExpenses, 2, ',', '.');

        return view('dashboard', compact('totalMembers', 'totalSavings', 'totalIncome', 'totalExpenses', 'formattedTotalIncome', 'formattedTotalExpenses'));
    }
}
