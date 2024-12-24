<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman; // Make sure to import your Pinjaman model
use App\Models\Anggota; // Import the Anggota model if needed
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

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
                    <a href="' . route('loans.edit', $loan) . '" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="' . route('loans.destroy', $loan) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this loan?\');">
                            <i class="fas fa-trash"></i> Delete
                        </button>
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
        // Validate the incoming request data
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'jumlah' => 'required',
            'bunga' => 'required|numeric',
            'tanggal_ajukan' => 'required|date',
            'status' => 'required|in:Disetujui,Belum Disetujui,Diambil',
        ]);

        // Convert the 'jumlah' field to a numeric value
        $data = $request->all();
        $data['jumlah'] = str_replace('.', '', $data['jumlah']); // Remove periods
        $data['jumlah'] = (float) $data['jumlah']; // Convert to float

        try {
            // Use a transaction to ensure data integrity
            DB::transaction(function () use ($data) {
                // Attempt to create a new loan entry
                Pinjaman::create($data);
            });

            // Return a success response
            return response()->json(['message' => 'Loan created successfully.'], 200);
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            return response()->json(['message' => 'Failed to create loan: ' . $e->getMessage()], 500);
        }
    }


    public function show(Pinjaman $pinjaman)
    {
        return view('loans.show', compact('pinjaman'));
    }

    public function edit($id)
    {
        $anggota = Anggota::all(); // Fetch all members for the dropdown
        $loan = Pinjaman::where('id_pinjaman',$id)->first();
        return view('loans.edit', ['loan' => $loan, 'anggota' => $anggota]);
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
