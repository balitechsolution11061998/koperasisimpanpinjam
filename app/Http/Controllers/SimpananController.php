<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Transaksi; // Import the Transaksi model
use App\Models\Anggota;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all(); // Get all members for the dropdown
        return view('simpanan.index', compact('anggota'));
    }

    public function data()
    {
        // Fetch all simpanan with anggota relationship
        $simpanan = Simpanan::with('anggota')->get();

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
        DB::beginTransaction(); // Start the transaction

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

            // Log the transaction as income
            Transaksi::create([
                'id_anggota' => $request->id_anggota,
                'tipe_transaksi' => 'Simpan',
                'jumlah' => $jumlah,
                'tanggal_transaksi' => $request->tanggal_simpan,
                'keterangan' => 'Deposit into savings',
            ]);

            // Create a new Pemasukan record with 'sumber' set to 'Simpanan'
            Pemasukan::create([
                'sumber' => 'Simpanan', // Set the source of income to 'Simpanan'
                'jumlah' => $jumlah, // Amount
                'tanggal' => $request->tanggal_simpan, // Date of income
            ]);

            DB::commit(); // Commit the transaction

            // Redirect with success message
            return redirect()->route('simpanan.index')->with('success', 'Simpanan created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback the transaction on validation error
            return redirect()->route('simpanan.index')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on general error
            \Log::error('Error creating simpanan: ' . $e->getMessage()); // Log the error message

            // Redirect back with a specific error message
            return redirect()->route('simpanan.index')->with('error', 'Failed to create simpanan: ' . $e->getMessage());
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

        try {
            // Find the existing Simpanan record
            $simpanan = Simpanan::findOrFail($id);

            // Update the record with the validated data
            $simpanan->update(array_merge($request->all(), ['jumlah' => $jumlah])); // Include the formatted jumlah

            // Log the transaction as an update (if applicable)
            Transaksi::create([
                'id_anggota' => $request->id_anggota,
                'tipe_transaksi' => 'Update Simpanan',
                'jumlah' => $jumlah,
                'tanggal_transaksi' => $request->tanggal_simpan,
                'keterangan' => 'Updated savings record',
            ]);

            // Redirect with success message
            return redirect()->route('simpanan.index')->with('success', 'Simpanan updated successfully!');
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Error updating simpanan: ' . $e->getMessage());

            // Redirect back with a specific error message
            return redirect()->route('simpanan.index')->with('error', 'Failed to update simpanan: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $simpanan = Simpanan::findOrFail($id);

        // Log the transaction as an expense
        Transaksi::create([
            'id_anggota' => $simpanan->id_anggota,
            'tipe_transaksi' => 'Penarikan',
            'jumlah' => $simpanan->jumlah,
            'tanggal_transaksi' => now(), // Use the current date for the transaction
            'keterangan' => 'Withdrawal from savings',
        ]);

        $simpanan->delete();
        return response()->json(['success' => 'Simpanan deleted successfully!']);
    }
}
