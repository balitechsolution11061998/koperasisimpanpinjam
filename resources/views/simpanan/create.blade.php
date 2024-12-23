@extends('adminlte::page')

@section('title', 'Add Simpanan')

@section('css')
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="card-title">Add Simpanan</h1>
            </div>
            <div class="card-body">
                <form id="simpananForm" action="{{ route('simpanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_anggota" class="form-label">Nama Anggota</label>
                        <select class="form-select" name="id_anggota" id="id_anggota" required>
                            <option value="">Select Anggota</option>
                            @foreach ($anggota as $member)
                                <option value="{{ $member->id_anggota }}">{{ $member->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
                        <select class="form-select" name="jenis_simpanan" id="jenis_simpanan" required>
                            <option value="Simpanan Pokok">Simpanan Pokok</option>
                            <option value="Simpanan Wajib">Simpanan Wajib</option>
                            <option value="Simpanan Sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_simpan" class="form-label">Tanggal Simpan</label>
                        <input type="date" class="form-control" name="tanggal_simpan" id="tanggal_simpan" required>
                    </div>
                    <div class="mb-3">
                        <label for="bunga" class="form-label">Bunga (optional)</label>
                        <input type="number" class="form-control" name="bunga" id="bunga" step="0.01">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Simpanan</button>
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
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            // Handle form submission
            $('#simpananForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to save this simpanan?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
@endsection
