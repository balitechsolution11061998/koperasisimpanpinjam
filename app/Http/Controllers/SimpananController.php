<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota; // Assuming you have an Anggota model
use Illuminate\Http\Request;
use DataTables;

class SimpananController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all(); // Get all members for the dropdown
        return view('simpanan.index',compact('anggota'));
    }

    public function data()
    {
        // Fetch all simpanan with anggota relationship
        $simpanan = Simpanan::with('anggota')->get();

        // Calculate total savings including interest
        $totalSimpanan = $simpanan->sum(function ($item) {
            return $item->totalSimpanan(); // Use the method to calculate total for each simpanan
        });

        // Prepare DataTables response
        return DataTables::of($simpanan)
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-primary btn-sm edit" data-id="' . $row->id_simpanan . '">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $row->id_simpanan . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                ';
            })
            ->addColumn('total_simpanan', function ($row) {
                return 'Rp. ' . number_format($row->totalSimpanan(), 2, ',', '.'); // Format total as Rupiah
            })
            ->make(true);
    }


    public function create()
    {
        $anggota = Anggota::all(); // Get all members for the dropdown
        return view('simpanan.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'id_anggota' => 'required|exists:anggota,id_anggota',
                'jenis_simpanan' => 'required|in:Simpanan Pokok,Simpanan Wajib,Simpanan Sukarela',
                'jumlah' => 'required|string', // Accept as string for formatting
                'tanggal_simpan' => 'required|date',
                'bunga' => 'nullable|numeric',
            ]);

            // Convert the "jumlah" to a numeric value by removing formatting
            $jumlah = str_replace(['Rp. ', '.', ','], '', $request->jumlah); // Remove currency symbol and formatting
            $jumlah = floatval($jumlah); // Convert to float

            // Create the new Simpanan record
            Simpanan::create(array_merge($request->all(), ['jumlah' => $jumlah])); // Include the formatted jumlah

            // Redirect with success message
            return redirect()->route('simpanan.index')->with('success', 'Simpanan created successfully!');
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Error creating simpanan: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->route('simpanan.index')->with('error', 'Failed to create simpanan. Please try again.');
        }
    }


    public function edit($id)
    {
        try {
            $simpanan = Simpanan::findOrFail($id);
            return response()->json($simpanan); // Return the simpanan data as JSON
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch simpanan data.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'jenis_simpanan' => 'required|in:Simpanan Pokok,Simpanan Wajib,Simpanan Sukarela',
            'jumlah' => 'required|numeric',
            'tanggal_simpan' => 'required|date',
            'bunga' => 'nullable|numeric',
        ]);

        $simpanan = Simpanan::findOrFail($id);
        $simpanan->update($request->all());

        return redirect()->route('simpanan.index')->with('success', 'Simpanan updated successfully!');
    }

    public function destroy($id)
    {
        $simpanan = Simpanan::findOrFail($id);
        $simpanan->delete();
        return response()->json(['success' => 'Simpanan deleted successfully!']);
    }
}
