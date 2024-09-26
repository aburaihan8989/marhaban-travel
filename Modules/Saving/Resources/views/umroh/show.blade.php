@extends('layouts.app')

@section('title', 'Umroh Savings Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-savings.index') }}">Umroh Savings</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            ID Register : <strong>{{ $umroh_saving->reference }}</strong>
                        </div>
                        <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('umroh-savings.pdf', $umroh_saving->id) }}">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('umroh-savings.pdf', $umroh_saving->id) }}">
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Category : <strong>Umroh Savings</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Travel Info:</h5>
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                                <div>Phone: {{ settings()->company_phone }}</div>
                                <div>Email: {{ settings()->company_email }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Customer Info:</h5>
                                <div><strong>{{ $customer->customer_name }}</strong></div>
                                <div>{{ $customer->address }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                                <div>Email: {{ $customer->customer_email }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Agent / Sponsor Info:</h5>
                                <div><strong>{{ $agent->agent_code . ' | ' . $agent->agent_name }}</strong></div>
                                <div>{{ $agent->address }}</div>
                                <div>Phone: {{ $agent->agent_phone }}</div>
                                <div>Email: {{ $agent->agent_email }}</div>
                            </div>

                            {{-- <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                                <div>Invoice: <strong>INV/{{ $purchase->reference }}</strong></div>
                                <div>Date: {{ \Carbon\Carbon::parse($purchase->date)->format('d M, Y') }}</div>
                                <div>
                                    Status: <strong>{{ $purchase->status }}</strong>
                                </div>
                                <div>
                                    Payment Status: <strong>{{ $purchase->payment_status }}</strong>
                                </div>
                            </div> --}}

                        </div>

                        <div class="table-responsive-sm mb-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">ID Reference</th>
                                        <th class="align-middle">Register Date</th>
                                        <th class="align-middle">Customer Name</th>
                                        <th class="align-middle">Phone Number</th>
                                        <th class="align-middle">Account Name</th>
                                        <th class="align-middle">Account Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $umroh_saving->reference }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ date('d-m-Y', strtotime($umroh_saving->register_date)) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $umroh_saving->customer_name }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $umroh_saving->customer_phone }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $umroh_saving->customer_bank }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $umroh_saving->bank_account }}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Saving Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge badge-success" style="font-size: 16px;">
                                                {{ $umroh_saving->status }}
                                            </span>
                                        </td>
                                        <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                            {{ format_currency($umroh_saving->total_saving) }}
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-5 ml-md-auto">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="left"><strong>PT {{ settings()->company_name }}</strong></td>
                                            {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0">
                                                <img width="180" src="{{ asset('images/sign.png') }}" alt="Sign">
                                            </td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"><strong>{{ settings()->sign_name }}</strong></td>
                                            {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

