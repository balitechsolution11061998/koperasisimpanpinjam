@extends('adminlte::page')

@section('title', 'Add Anggota')

@section('content')
<div class="container mt-4">
    <h1>Add New Member</h1>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Member Information</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_daftar">Tanggal Daftar</label>
                    <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar" required>
                </div>
                <div class="form-group">
                    <label for="status_keanggotaan">Status Keanggotaan</label>
                    <select class="form-control" id="status_keanggotaan" name="status_keanggotaan" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Member</button>
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@stop
