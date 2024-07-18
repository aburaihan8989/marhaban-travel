@extends('layouts.app')

@section('title', 'Home')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Home</li>
    </ol>
@endsection
{{-- @dd($dataTable); --}}
@section('content')
    <div class="container-fluid">
        @can('show_total_stats')
            <li class="breadcrumb-item active">Home Dashboard</li>
            <hr>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary p-3 mfe-3 rounded">
                                <i class="bi bi-cash-stack font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($umroh_payment) }}</div>
                                <div class="text-uppercase font-weight-bold small">Umroh Transactions</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-warning p-3 mfe-3 rounded">
                                <i class="bi bi-cash font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($umroh_expense) }}</div>
                                <div class="text-uppercase font-weight-bold small">Umroh Expenses</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-success p-3 mfe-3 rounded">
                                <i class="bi bi-trophy font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($umroh_profit) }}</div>
                                <div class="text-uppercase font-weight-bold small">Umroh Margin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary p-3 mfe-3 rounded">
                                <i class="bi bi-cash-stack font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($hajj_payment) }}</div>
                                <div class="text-uppercase font-weight-bold small">Hajj Transactions</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-warning p-3 mfe-3 rounded">
                                <i class="bi bi-cash font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($hajj_expense) }}</div>
                                <div class="text-uppercase font-weight-bold small">Hajj Expenses</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-success p-3 mfe-3 rounded">
                                <i class="bi bi-trophy font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($hajj_profit) }}</div>
                                <div class="text-uppercase font-weight-bold small">Hajj Margin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary p-3 mfe-3 rounded">
                                <i class="bi bi-cash-stack font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($umroh_savings) }}</div>
                                <div class="text-uppercase font-weight-bold small">Umroh Savings</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary p-3 mfe-3 rounded">
                                <i class="bi bi-cash-stack font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ format_currency($hajj_savings) }}</div>
                                <div class="text-uppercase font-weight-bold small">Hajj Savings</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <li class="breadcrumb-item active">Database Management</li>
            <hr>

            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-people font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Registered Customers</div>
                                <div class="text-value text-primary">{{ $customers . ' Customers' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-people font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Registered Agents</div>
                                <div class="text-value text-primary">{{ $agents . ' Agents' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-people font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Umroh Savings Customers</div>
                                <div class="text-value text-primary">{{ $customers_umroh_savings . ' Customers' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-people font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Hajj Savings Customers</div>
                                <div class="text-value text-primary">{{ $customers_hajj_savings . ' Customers' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                                <i class="bi bi-journal-check font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Approval Savings</div>
                                <div class="text-value text-primary">{{ $payment_savings . ' Transactions' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                                <i class="bi bi-journal-check font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Approval Payments</div>
                                <div class="text-value text-primary">{{ $payment_packages . ' Transactions' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <li class="breadcrumb-item active">Package Management</li>
            <hr>

            {{-- <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Umroh Package : <strong>List Active Umroh Package</strong>
                            </div>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                                {!! $dataTable->table() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Hajj Package : <strong>List Active Hajj Package</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {!! $dataTable->table() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Tabel : <strong>Data List Umroh Package Active </i></strong>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center mb-0">
                                    <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Package Code</th>
                                            <th>Package Name</th>
                                            <th>Departure Date</th>
                                            <th>Departure Location</th>
                                            <th>Flight Route</th>
                                            <th>Days</th>
                                            <th>Seat</th>
                                            <th>Booked</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($umroh_package as $umroh_package)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $umroh_package['package_code'] }}</td>
                                                <td>{{ $umroh_package['package_name'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($umroh_package['package_date'])->format('d-m-Y') }}</td>
                                                <td>{{ $umroh_package['package_departure'] }}</td>
                                                <td>{{ $umroh_package['flight_route'] }}</td>
                                                <td>{{ $umroh_package['package_days'] }} Days</td>
                                                <td>{{ $umroh_package['package_capacity'] }} Pax</td>
                                                <td>{{ $umroh_package['umroh_customer_count'] }} Pax</td>
                                                <td>{{ $umroh_package['package_capacity'] - $umroh_package['umroh_customer_count'] }} Pax</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">
                                                    <span class="text-danger">No Data Available!</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div @class(['mt-3' => $umroh_package->hasPages()])>
                                {{ $umroh_package->links() }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Tabel : <strong>Data List Hajj Package Active </i></strong>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center mb-0">
                                    <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Package Code</th>
                                            <th>Package Name</th>
                                            <th>Departure Date</th>
                                            <th>Departure Location</th>
                                            <th>Flight Route</th>
                                            <th>Days</th>
                                            <th>Seat</th>
                                            <th>Booked</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($hajj_package as $hajj_package)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $hajj_package['package_code'] }}</td>
                                                <td>{{ $hajj_package['package_name'] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($hajj_package['package_date'])->format('d-m-Y') }}</td>
                                                <td>{{ $hajj_package['package_departure'] }}</td>
                                                <td>{{ $hajj_package['flight_route'] }}</td>
                                                <td>{{ $hajj_package['package_days'] }} Days</td>
                                                <td>{{ $hajj_package['package_capacity'] }} Pax</td>
                                                <td>{{ $hajj_package['hajj_customer_count'] }} Pax</td>
                                                <td>{{ $hajj_package['package_capacity'] - $hajj_package['hajj_customer_count'] }} Pax</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10">
                                                    <span class="text-danger">No Data Available!</span>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div @class(['mt-3' => $umroh_package->hasPages()])>
                                {{ $umroh_package->links() }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <br>

        @endcan

    </div>
@endsection

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@push('page_scripts')
    @vite('resources/js/chart-config.js')
    {!! $dataTable->scripts() !!}
@endpush
