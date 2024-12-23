<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman; // Make sure to import your Pinjaman model
use App\Models\Anggota; // Import the Anggota model if needed
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all(); // Fetch all members for the dropdown
        return view('loans.index', compact('anggota'));
    }

    public function create()
    {
        $anggota = Anggota::all(); // Fetch all members for the dropdown
        return view('loans.create', compact('anggota'));
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $loans = Pinjaman::with('anggota')->get(); // Fetch loans with related members
            return DataTables::of($loans)
                ->addColumn('actions', function ($loan) {
                    return '
                    <a href="' . route('loans.edit', $loan) . '" class="btn btn-warning">Edit</a>
                    <form action="' . route('loans.destroy', $loan) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                ';
                })
                ->editColumn('jumlah', function ($loan) {
                    return 'Rp ' . number_format($loan->jumlah, 2, ',', '.');
                })
                ->editColumn('bunga', function ($loan) {
                    return $loan->bunga . '%';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'jumlah' => 'required|numeric',
            'bunga' => 'required|numeric',
            'tanggal_ajukan' => 'required|date',
            'status' => 'required|in:Disetujui,Belum Disetujui,Diambil',
        ]);

        Pinjaman::create($request->all());
        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    public function show(Pinjaman $pinjaman)
    {
        return view('loans.show', compact('pinjaman'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $members = Anggota::all(); // Fetch all members for the dropdown
        return view('loans.edit', compact('pinjaman', 'members'));
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'jumlah' => 'required|numeric',
            'bunga' => 'required|numeric',
            'tanggal_ajukan' => 'required|date',
            'status' => 'required|in:Disetujui,Belum Disetujui,Diambil',
        ]);

        $pinjaman->update($request->all());
        return redirect()->route('pinjaman.index')->with('success', 'Loan updated successfully.');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();
        return redirect()->route('pinjaman.index')->with('success', 'Loan deleted successfully.');
    }
}
