@extends('adminlte::page')

@section('title', 'Loans')

@section('css')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <h1 class="card-title">Data Loans</h1>
                <a href="{{ route('loans.create') }}" class="btn btn-light btn-sm float-end">
                    <i class="fas fa-plus"></i> Add Loan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive"> <!-- Make the table responsive -->
                    <table class="table table-bordered table-striped" id="loansTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Member</th>
                                <th>Amount</th>
                                <th>Interest</th>
                                <th>Status</th>
                                <th>Actions</th>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Loan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_pinjaman" id="id_pinjaman">
                        <div class="mb-3">
                            <label for="id_anggota" class="form-label">Member</label>
                            <select class="form-select" name="id_anggota" id="id_anggota" required>
                                <option value="">Select Member</option>
                                @foreach ($anggota as $member)
                                    <option value="{{ $member->id_anggota }}">{{ $member->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Amount</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="bunga" class="form-label">Interest (%)</label>
                            <input type="number" class="form-control" name="bunga" id="bunga" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Belum Disetujui">Belum Disetujui</option>
                                <option value="Diambil">Diambil</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Loan</button>
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
    <script>
        $(document).ready(function() {
            var table = $('#loansTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('loans.data') }}',
                columns: [
                    { data: 'id_pinjaman', name: 'id_pinjaman' },
                    { data: 'anggota.nama', name: 'anggota.nama' }, // Assuming 'nama' is the column in anggota table
                    { data: 'jumlah', name: 'jumlah', render: function(data) {
                        return data;
                    }},
                    { data: 'bunga', name: 'bunga' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            // Handle edit button click
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                // Fetch the data for the selected id
                $.ajax({
                    url: '/pinjaman/' + id + '/edit', // Adjust the URL according to your route
                    method: 'GET',
                    success: function(data) {
                        // Populate the form with the data
                        $('#editForm #id_anggota').val(data.id_anggota);
                        $('#editForm #jumlah').val(data.jumlah);
                        $('#editForm #bunga').val(data.bunga);
                        $('#editForm #status').val(data.status);
                        $('#editForm #id_pinjaman').val(data.id_pinjaman); // Hidden field for ID

                        // Set the form action to the update route
                        $('#editForm').attr('action', '/pinjaman/' + data.id_pinjaman); // Set the action URL

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
                            url: '/pinjaman/' + id,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload(); // Reload the DataTable
                                toastr.success('Loan deleted successfully!');
                            },
                            error: function(xhr) {
                                toastr.error('Failed to delete loan.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
