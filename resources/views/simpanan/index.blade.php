@extends('adminlte::page')

@section('title', 'Simpanan')

@section('css')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .card-header {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
        }
        .badge {
            font-size: 0.9rem;
        }
        .table th {
            background-color: #f8f9fa; /* Light gray for table header */
        }
        .table td {
            vertical-align: middle; /* Center align table cells */
        }
        .alert {
            margin-bottom: 20px; /* Space between alerts and other content */
        }
    </style>
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
                <h1 class="card-title">Data Simpanan</h1>
                <a href="{{ route('simpanan.create') }}" class="btn btn-light btn-sm float-end">
                    <i class="fas fa-plus"></i> Add Simpanan
                </a>
            </div>
            <div class="card-body">
                <h5>Total Simpanan: <span id="totalSimpanan" class="text-success">Rp. 0</span></h5> <!-- Placeholder for total savings -->
                <div class="table-responsive"> <!-- Make the table responsive -->
                    <table class="table table-bordered table-striped" id="simpananTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Jenis Simpanan</th>
                                <th>Jumlah</th>
                                <th>Tanggal Simpan</th>
                                <th>Bunga (%)</th> <!-- Updated header for Bunga -->
                                <th>Total Simpanan</th> <!-- New column for total savings -->
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Simpanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_simpanan" id="id_simpanan">
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
                            <label for="bunga" class="form-label">Bunga (%)</label>
                            <input type="number" class="form-control" name="bunga" id="bunga" step="0.01">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Simpanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#simpananTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('simpanan.data') }}",
                responsive: true,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false
                    },
                    {
                        data: 'anggota.nama',
                        name: 'anggota.nama'
                    },
                    {
                        data: 'jenis_simpanan',
                        name: 'jenis_simpanan',
                        render: function(data) {
                            switch (data) {
                                case 'Simpanan Pokok':
                                    return '<span class="badge bg-primary">' + data + '</span>';
                                case 'Simpanan Wajib':
                                    return '<span class="badge bg-success">' + data + '</span>';
                                case 'Simpanan Sukarela':
                                    return '<span class="badge bg-warning">' + data + '</span>';
                                default:
                                    return data; // Fallback for any other types
                            }
                        }
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        render: function(data) {
                            return 'Rp. ' + parseFloat(data).toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'tanggal_simpan',
                        name: 'tanggal_simpan'
                    },
                    {
                        data: 'bunga',
                        name: 'bunga',
                        render: function(data) {
                            return parseFloat(data).toFixed(2) + ' %';
                        }
                    },
                    {
                        data: 'total_simpanan',
                        name: 'total_simpanan',
                        render: function(data, type, row) {
                            var jumlah = parseFloat(row.jumlah);
                            var bunga = parseFloat(row.bunga) || 0;
                            var total = jumlah + (jumlah * bunga / 100); // Calculate total simpanan
                            return 'Rp. ' + total.toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-primary btn-sm edit" data-id="${row.id_simpanan}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete" data-id="${row.id_simpanan}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            `;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var totalPokok = 0;
                    var totalWajib = 0;
                    var totalSukarela = 0;

                    api.rows().data().each(function(row) {
                        var jumlah = parseFloat(row.jumlah);
                        var bunga = parseFloat(row.bunga) || 0;
                        var totalSimpanan = jumlah + (jumlah * bunga / 100);

                        // Accumulate totals based on jenis_simpanan
                        switch (row.jenis_simpanan) {
                            case 'Simpanan Pokok':
                                totalPokok += totalSimpanan;
                                break;
                            case 'Simpanan Wajib':
                                totalWajib += totalSimpanan;
                                break;
                            case 'Simpanan Sukarela':
                                totalSukarela += totalSimpanan;
                                break;
                        }
                    });

                    // Update the total savings display
                    $('#totalSimpanan').html(`
                        <strong>Total Simpanan:</strong><br>
                        Simpanan Pokok: Rp. ${totalPokok.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
                        Simpanan Wajib: Rp. ${totalWajib.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
                        Simpanan Sukarela: Rp. ${totalSukarela.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                    `);
                }
            });

            // Handle edit button click
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                // Fetch the data for the selected id
                $.ajax({
                    url: '/simpanan/' + id + '/edit', // Adjust the URL according to your route
                    method: 'GET',
                    success: function(data) {
                        // Populate the form with the data
                        $('#editForm #id_anggota').val(data.id_anggota);
                        $('#editForm #jenis_simpanan').val(data.jenis_simpanan);
                        $('#editForm #jumlah').val(data.jumlah); // Set the raw value for input
                        $('#editForm #tanggal_simpan').val(data.tanggal_simpan);
                        $('#editForm #bunga').val(data.bunga); // Set the raw value for input
                        $('#editForm #id_simpanan').val(data.id_simpanan); // Hidden field for ID

                        // Set the form action to the update route
                        $('#editForm').attr('action', '/simpanan/' + data.id_simpanan); // Set the action URL

                        $('#editModal').modal('show'); // Show the modal
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        toastr.error('Failed to fetch data for editing.');
                    }
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/simpanan/' + id,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload(); // Reload the DataTable
                                toastr.success('Simpanan deleted successfully!');
                            },
                            error: function(xhr) {
                                toastr.error('Failed to delete simpanan.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
