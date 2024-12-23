<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnggotaController extends Controller
{
    // Display the list of members
    public function index()
    {
        return view('anggota.index');
    }

    // Fetch data for DataTables
    public function getData()
    {
        $anggota = Anggota::query();

        return DataTables::of($anggota)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-primary edit" data-id="' . $row->id_anggota . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete" data-id="' . $row->id_anggota . '">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Show the form for creating a new member
    public function create()
    {
        return view('anggota.create');
    }

    // Store a newly created member
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:anggota',
            'tanggal_daftar' => 'required|date',
            'status_keanggotaan' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')->with('status', 'Member created successfully!');
    }

    // Show the form for editing the specified member
    public function edit($id)
    {
        $anggota = Anggota::where('id_anggota',$id)->first();
        return response()->json($anggota);
    }

    // Update the specified member
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:anggota,email,' . $id . ',id_anggota', // Correctly reference id_anggota
            'tanggal_daftar' => 'required|date',
            'status_keanggotaan' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $anggota = Anggota::where('id_anggota', $id)->first();
        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('status', 'Member updated successfully!');
    }


    // Remove the specified member
    public function destroy($id)
    {
        $anggota = Anggota::where('id_anggota',$id)->first();
        $anggota->delete();

        return response()->json(['success' => 'Member deleted successfully!']);
    }
}
