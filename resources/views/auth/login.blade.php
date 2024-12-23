<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link ke Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Link ke SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang */
        }

        .container {
            max-width: 400px;
            /* Lebar maksimum kontainer */
            margin-top: 100px;
            /* Margin atas untuk memposisikan kontainer di tengah */
            padding: 20px;
            background-color: white;
            /* Warna latar belakang kontainer */
            border-radius: 8px;
            /* Sudut melengkung */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Bayangan */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Login</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
    </div>

    <!-- Link ke jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Link ke Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link ke Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Link ke SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
            event.preventDefault(); // Mencegah pengiriman form default

            // Ambil data form
            var formData = new FormData(this);

            // Kirim data menggunakan Fetch API
            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan SweetAlert jika login berhasil
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect ke halaman dashboard setelah pengguna menekan OK
                            window.location.href = '{{ route('dashboard') }}'; // Pastikan route login benar
                        });
                    } else {
                        // Tampilkan Toastr jika ada kesalahan
                        toastr.error(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                });
        };
    </script>
</body>

</html>
