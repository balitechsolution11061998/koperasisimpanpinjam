<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Artha Niaga</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .navbar.scrolled {
            background-color: green; /* Set background color to green when scrolled */
        }

        .navbar-nav .nav-link {
            color: white; /* Set link color to white */
            font-weight: bold; /* Set font weight to bold */
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar.scrolled .nav-link {
            color: white; /* Set link color to white when scrolled */
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107; /* Change color on hover to a contrasting color */
            transform: scale(1.1);
        }

        .logo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .hero-section {
            background: url('/vendor/adminlte/dist/img/background.jpeg') no-repeat center center;
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .animated-title {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin: 0;
        }

        .hero-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 400;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            margin: 10px 0;
        }

        .content-section {
            padding: 60px 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer a {
            color: #f8f9fa;
            margin: 0 10px;
        }

        .footer a:hover {
            color: #ffc107;
        }

        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        #backToTop:hover {
            background-color: #0056b3;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .service-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-card .form-label {
            font-weight: bold;
        }

        .loan-calculation-card {
            background-color: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            font-family: 'Montserrat', sans-serif;
            color: #007bff;
        }

        .about-card, .loan-calculation-card, .testimonial-card {
            transition: transform 0.3s;
        }

        .about-card:hover, .loan-calculation-card:hover, .testimonial-card:hover {
            transform: scale(1.02);
        }

        /* New background for testimonials */
        .testimonial-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Button styles */
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-transparent position-fixed w-100 px-4">
        <div class="container">
            <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="Logo" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a href="#aboutSection" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
                    <a href="#contactSection" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a>
                    <a href="#" class="nav-link"><i class="fas fa-home"></i> Home</a>
                    <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        {{-- <div class="container animated-title">
            <h1 class="hero-title">Koperasi Simpan Pinjam <br> Artha Niaga</h1>
            <h3 class="hero-subtitle">(Primer Nasional)</h3>
            <p class="mt-4">
                BADAN HUKUM: NO. 353/BH/XIV/16/III/2008<br>
                PAD: 305/PAD/DEP.1/X/2018
            </p>
            <p class="mt-4">
                Alamat: Jl. Grecol RT003/002 Kalimanah, Purbalingga
            </p>
        </div> --}}
    </section>

    <!-- About Section -->
    <section id="aboutSection" class="content-section fade-in">
        <div class="container text-center">
            <h2 style="margin-bottom: 30px;">About Us</h2>
            <div class="about-card">
                <p class="mt-4" style="font-size: 1.2rem;">Koperasi Artha Niaga is a cooperative that provides
                    financial services to its members. Our mission is to promote savings and provide loans to help our
                    members achieve their financial goals.</p>
                <p style="font-size: 1.2rem;">Founded in 2008, we have been committed to serving our community with
                    integrity and transparency.</p>
                <p style="font-size: 1.2rem;">We believe in empowering our members through financial education and
                    support, ensuring that everyone has the opportunity to achieve their financial aspirations.</p>
            </div>
        </div>
    </section>

    <!-- Loan Calculation Section -->
    <section class="content-section fade-in" style="background-color: #f0f4ff; padding: 60px 0;">
        <div class="container text-center">
            <h2 style="margin-bottom: 30px;">Hitung Pinjaman</h2>
            <div class="loan-calculation-card">
                <form id="loanForm">
                    <div class="mb-4">
                        <label for="loanAmount" class="form-label" style="font-size: 1.2rem;">Jumlah Pinjaman
                            (IDR)</label>
                        <input type="text" class="form-control" id="loanAmount" required
                            onkeyup="formatCurrency(this)" style="font-size: 1.2rem;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="font-size: 1.2rem;">Hitung</button>
                </form>
                <div id="result" class="result mt-4" style="font-size: 1.2rem;"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="content-section fade-in" style="background-color: #f0f4ff; padding: 60px 0;">
        <div class="container text-center">
            <h2 class="mb-4">What Our Members Say</h2>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"
                style="max-width: 800px; margin: auto;">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="testimonial-card card rounded">
                            <div class="card-body text-center">
                                <img src="{{ asset('img/background/blank.jpg') }}" alt="John Doe" class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 15px;">
                                <blockquote class="blockquote">
                                    <p class="mb-0">"Koperasi Artha Niaga has helped me achieve my financial goals!"
                                    </p>
                                    <footer class="blockquote-footer" style="padding-top: 10px;">
                                        <i class="fas fa-user-friends"></i> John Doe
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card card rounded">
                            <div class="card-body text-center">
                                <img src="{{ asset('img/background/blank.jpg') }}" alt="Jane Smith" class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 15px;">
                                <blockquote class="blockquote">
                                    <p class="mb-0">"The loan process was quick and easy!"</p>
                                    <footer class="blockquote-footer" style="padding-top: 10px;">
                                        <i class="fas fa-user-friends"></i> Jane Smith
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card card rounded">
                            <div class="card-body text-center">
                                <img src="{{ asset('img/background/blank.jpg') }}" alt="Alice Johnson" class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 15px;">
                                <blockquote class="blockquote">
                                    <p class="mb-0">"I love the savings plans offered here!"</p>
                                    <footer class="blockquote-footer" style="padding-top: 10px;">
                                        <i class="fas fa-user-friends"></i> Alice Johnson
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contactSection" class="content-section fade-in">
        <div class="container text-center">
            <div class="contact-card">
                <h2><i class="fas fa-envelope"></i> Contact Us</h2>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-comment"></i></span>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-left">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="content-section fade-in" style="background-color: #f0f4ff; padding: 60px 0;">
        <div class="container text-center">
            <h2 style="font-family: 'Montserrat', sans-serif; color: #007bff; margin-bottom: 30px;">Our Services</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-piggy-bank fa-3x" style="color: #007bff; margin-bottom: 15px;"></i>
                            <h5 class="card-title">Savings</h5>
                            <p class="card-text">We offer various savings plans to help you grow your wealth. Our
                                competitive interest rates ensure that your savings work for you.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-money-bill-wave fa-3x" style="color: #007bff; margin-bottom: 15px;"></i>
                            <h5 class="card-title">Loans</h5>
                            <p class="card-text">Flexible loan options to meet your financial needs. Whether it's for
                                personal use or business expansion, we have the right solution for you.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x" style="color: #007bff; margin-bottom: 15px;"></i>
                            <h5 class="card-title">Investment</h5>
                            <p class="card-text">Investment opportunities to secure your future. Our expert advisors
                                are here to help you make informed decisions for long-term growth.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Koperasi Artha Niaga. All rights reserved.</p>
            <p>Follow us on
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" onclick="scrollToTop()"><i class="fas fa-chevron-up"></i></button>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            const formattedValue = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
            input.value = formattedValue;
        }

        document.getElementById('loanForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const loanAmount = parseFloat(document.getElementById('loanAmount').value.replace(/[^0-9]/g, ''));
            if (!isNaN(loanAmount)) {
                const totalRepayment = loanAmount * 1.2;
                const profit = totalRepayment - loanAmount;
                const mandatorySavings = loanAmount * 0.05;

                const formatRupiah = (amount) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(amount);
                };

                document.getElementById('result').innerHTML = `
                    <h4>Hasil Perhitungan:</h4>
                    <p>Total Pengembalian: ${formatRupiah(totalRepayment)}</p>
                    <p>Keuntungan Koperasi: ${formatRupiah(profit)}</p>
                    <p>Tabungan Wajib: ${formatRupiah(mandatorySavings)}</p>
                `;
            } else {
                document.getElementById('result').innerHTML = '';
            }
        });

        window.onscroll = function() {
            const backToTopButton = document.getElementById("backToTop");
            const navbar = document.querySelector('.navbar');
            const fadeInElements = document.querySelectorAll('.fade-in');
            const serviceCards = document.querySelectorAll('.service-card');

            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopButton.style.display = "block";
                navbar.classList.add('scrolled');
            } else {
                backToTopButton.style.display = "none";
                navbar.classList.remove('scrolled');
            }

            fadeInElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    element.classList.add('visible');
                }
            });

            serviceCards.forEach(card => {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    card.classList.add('visible');
                }
            });
        };

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>
