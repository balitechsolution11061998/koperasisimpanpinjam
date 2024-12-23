@extends('adminlte::page')

@section('title', 'Anggota')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="card-title">Data Anggota</h1>
                    <a href="{{ route('anggota.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Add Member
                    </a>
                </div>

                <div class="mt-3"> <!-- Added margin-top for spacing -->
                    <table class="table table-bordered table-responsive" id="anggotaTable">
                        <thead>
                            <tr>
                                <th>No</th> <!-- Index Column -->
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status Keanggotaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST" action="{{ route('anggota.update', 'id_anggota_placeholder') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNomorTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="editNomorTelepon" name="nomor_telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggalDaftar" class="form-label">Tanggal Daftar</label>
                            <input type="date" class="form-control" id="editTanggalDaftar" name="tanggal_daftar" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatusKeanggotaan" class="form-label">Status Keanggotaan</label>
                            <select class="form-select" id="editStatusKeanggotaan" name="status_keanggotaan" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('css')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- Include Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery Validation JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            var table = $('#anggotaTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true, // Enable responsive feature
                ajax: "{{ route('anggota.data') }}",
                columns: [
                    {
                        data: null, // Use null for index column
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1; // Calculate index
                        },
                        orderable: false // Disable ordering for index column
                    },
                    { data: 'nama', name: 'nama' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'nomor_telepon', name: 'nomor_telepon' },
                    { data: 'email', name: 'email' },
                    { data: 'tanggal_daftar', name: 'tanggal_daftar' },
                    {
                        data: 'status_keanggotaan',
                        name: 'status_keanggotaan',
                        render: function(data) {
                            // Render status as a badge
                            if (data === 'Aktif') {
                                return '<span class="badge bg-success">Aktif</span>';
                            } else {
                                return '<span class="badge bg-danger">Tidak Aktif</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-primary btn-sm edit" data-id="${row.id_anggota}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete" data-id="${row.id_anggota}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            `;
                        }
                    }
                ]
            });

            // Edit member
            $('#anggotaTable').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("anggota/" + id + "/edit", function(data) {
                    $('#editId').val(data.id_anggota);
                    $('#editNama').val(data.nama);
                    $('#editAlamat').val(data.alamat);
                    $('#editNomorTelepon').val(data.nomor_telepon);
                    $('#editEmail').val(data.email);
                    $('#editTanggalDaftar').val(data.tanggal_daftar);
                    $('#editStatusKeanggotaan').val(data.status_keanggotaan);

                    // Set the form action URL
                    $('#editForm').attr('action', "{{ route('anggota.update', '') }}/" + data.id_anggota);

                    $('#editModal').modal('show');
                });
            });

            // Validate and submit the edit form
            $('#editForm').validate({
                submitHandler: function(form) {
                    var id = $('#editId').val();
                    $.ajax({
                        type: "PUT",
                        url: "anggota/" + id,
                        data: $(form).serialize(),
                        success: function(response) {
                            $('#editModal').modal('hide');
                            table.ajax.reload();
                            toastr.success('Member updated successfully!'); // Show success message
                        },
                        error: function(xhr) {
                            toastr.error('Failed to update member.'); // Show error message
                        }
                    });
                }
            });

            // Delete member
            $('#anggotaTable').on('click', '.delete', function() {
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
                            type: "DELETE",
                            url: "anggota/" + id,
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Member has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete member.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
@stop
