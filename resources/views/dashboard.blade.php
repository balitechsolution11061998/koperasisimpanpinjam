@extends('adminlte::page')

@section('title', 'Dashboard Koperasi Simpan Pinjam')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard Koperasi Simpan Pinjam</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="text-center">Welcome to Your Dashboard!</h5>
                    <p class="text-center">You are logged in!</p>

                    <div class="row mt-4">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card text-white bg-primary shadow">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-users"></i> Total Members
                                    </h5>
                                    <p class="card-text display-4">150</p>
                                    <a href="#" class="btn btn-light">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card text-white bg-success shadow">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-money-bill-wave"></i> Total Savings
                                    </h5>
                                    <p class="card-text display-4">Rp 1,500,000,000</p>
                                    <a href="#" class="btn btn-light">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card text-white bg-warning shadow">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-hand-holding-usd"></i> Total Loans
                                    </h5>
                                    <p class="card-text display-4">Rp 750,000,000</p>
                                    <a href="#" class="btn btn-light">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">Recent Transactions</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Member</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2024-12-01</td>
                                    <td>John Doe</td>
                                    <td>Deposit</td>
                                    <td>Rp 1,000,000</td>
                                </tr>
                                <tr>
                                    <td>2024-12-02</td>
                                    <td>Jane Smith</td>
                                    <td>Loan</td>
                                    <td>Rp 500,000</td>
                                </tr>
                                <tr>
                                    <td>2024-12-03</td>
                                    <td>Michael Johnson</td>
                                    <td>Deposit</td>
                                    <td>Rp 750,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-user"></i> Go to Profile
                        </a>
                        <a href="#" class="btn btn-secondary">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
