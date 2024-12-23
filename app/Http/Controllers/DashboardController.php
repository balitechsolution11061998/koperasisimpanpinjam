<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Fetch total members
        $totalMembers = Anggota::count();
        $totalIncome = 10000000; // Total income
        $totalExpenses = 5000000; // Total expenses
        // Fetch total savings
        $totalSavings = Simpanan::sum('jumlah'); // Assuming 'jumlah' is the field for savings
        return view('dashboard', compact('totalMembers', 'totalSavings', 'totalIncome', 'totalExpenses'));

    }
}
