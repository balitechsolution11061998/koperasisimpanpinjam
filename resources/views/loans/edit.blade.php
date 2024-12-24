@extends('adminlte::page')

@section('title', 'Edit Loan')

@section('css')
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="card-title">Edit Loan</h1>
            </div>
            <div class="card-body">
                <form id="editLoanForm" method="POST" action="{{ route('loans.update', $loan->id_pinjaman) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="id_anggota" class="form-label">Member Name <i class="fas fa-user"></i></label>
                        <select class="form-select" name="id_anggota" id="id_anggota" required>
                            <option value="">Select Member</option>
                            @foreach ($anggota as $member)
                                <option value="{{ $member->id_anggota }}" {{ $loan->id_anggota == $member->id_anggota ? 'selected' : '' }}>
                                    {{ $member->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Amount <i class="fas fa-money-bill-wave"></i></label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" value="{{ $loan->jumlah }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="bunga" class="form-label">Interest (%) <i class="fas fa-percent"></i></label>
                        <input type="number" class="form-control" name="bunga" id="bunga" value="{{ $loan->bunga }}" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <i class="fas fa-check-circle"></i></label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="Disetujui" {{ $loan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Belum Disetujui" {{ $loan->status == 'Belum Disetujui' ? 'selected' : '' }}>Belum Disetujui</option>
                            <option value="Diambil" {{ $loan->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Loan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Include Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to format number as Rupiah
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $(document).ready(function() {
            // Format the "jumlah" input as Rupiah
            $('#jumlah').on('keyup', function() {
                $(this).val(formatRupiah(this.value));
            });
        });
    </script>
@endsection