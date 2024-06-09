@extends('layouts.app')

@if ($hajjsavingPayment->trx_type == 'Saving')
    @section('title', 'Details Hajj Savings Payment')

    @section('breadcrumb')
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-savings.index') }}">Hajj Savings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-saving-payments.index', $hajjsavingPayment->saving_id) }}">{{ $hajj_saving->reference }}</a></li>
            <li class="breadcrumb-item active">Details Hajj Savings Payment</li>
        </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Register ID : <strong>{{ $hajjsavingPayment->reference }}</strong>
                            </div>
                            <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('umroh-saving-payments.pdf', $hajjsavingPayment->id) }}">
                                <i class="bi bi-printer"></i> Print
                            </a>
                            <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('umroh-saving-payments.pdf', $hajjsavingPayment->id) }}">
                                <i class="bi bi-save"></i> Save
                            </a>
                        </div>
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Category : <strong>Customer Savings Receipt</strong>
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
                                    <h5 class="mb-2 border-bottom pb-2">Agent Info:</h5>
                                    {{-- <div><strong>{{ $customer->customer_name }}</strong></div>
                                    <div>{{ $customer->address }}</div>
                                    <div>Phone: {{ $customer->customer_phone }}</div>
                                    <div>Email: {{ $customer->customer_email }}</div> --}}
                                </div>
                            </div>

                            <div class="table-responsive-sm mb-5">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Reference ID</th>
                                            <th class="align-middle">Saving Date</th>
                                            <th class="align-middle">Customer Name</th>
                                            <th class="align-middle">Phone Number</th>
                                            <th class="align-middle">Category</th>
                                            <th class="align-middle">Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">
                                                {{ $hajjsavingPayment->reference }}
                                            </td>
                                            <td class="align-middle">
                                                {{ date('d-m-Y', strtotime($hajjsavingPayment->date)) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajj_saving->customer_name }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajj_saving->customer_phone }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($hajjsavingPayment->trx_type == 'Saving')
                                                    <span class="badge badge-success" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->trx_type }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->trx_type }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajjsavingPayment->payment_method }}
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <table class="table table-striped col-lg-6">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Saving Amount</th>
                                            <th class="align-middle">Payment Status</th>
                                            <th class="align-middle">Saving Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                                {{ format_currency($hajjsavingPayment->amount) }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($hajjsavingPayment->status == 'Verified')
                                                    <span class="badge badge-success" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->status }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                                {{ format_currency($hajj_saving->total_saving) }}
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
                                            <td class="left"><strong>PT Marhaban Makkah Madinah</strong></td>
                                            {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"><strong>Direktur Utama</strong></td>
                                            {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <label for="savings">Savings Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                        @forelse($hajjsavingPayment->getMedia('savings') as $media)
                                            <img src="{{ $media->getUrl() }}" alt="Savings Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                        @empty
                                            <img src="{{ $hajjsavingPayment->getFirstMediaUrl('savings') }}" alt="Savings Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('title', 'Details Hajj Savings Refund')

    @section('breadcrumb')
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-savings.index') }}">Hajj Savings</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-saving-payments.index', $hajjsavingPayment->saving_id) }}">{{ $hajj_saving->reference }}</a></li>
            <li class="breadcrumb-item active">Details Hajj Savings Refund</li>
        </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Register ID : <strong>{{ $hajjsavingPayment->reference }}</strong>
                            </div>
                            <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('umroh-saving-payments.pdf', $hajjsavingPayment->id) }}">
                                <i class="bi bi-printer"></i> Print
                            </a>
                            <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('umroh-saving-payments.pdf', $hajjsavingPayment->id) }}">
                                <i class="bi bi-save"></i> Save
                            </a>
                        </div>
                        <div class="card-header d-flex flex-wrap align-items-center">
                            <div>
                                Category : <strong>Customer Refund Receipt</strong>
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
                                    <h5 class="mb-2 border-bottom pb-2">Agent Info:</h5>
                                    {{-- <div><strong>{{ $customer->customer_name }}</strong></div>
                                    <div>{{ $customer->address }}</div>
                                    <div>Phone: {{ $customer->customer_phone }}</div>
                                    <div>Email: {{ $customer->customer_email }}</div> --}}
                                </div>
                            </div>

                            <div class="table-responsive-sm mb-5">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Reference ID</th>
                                            <th class="align-middle">Refund Date</th>
                                            <th class="align-middle">Customer Name</th>
                                            <th class="align-middle">Phone Number</th>
                                            <th class="align-middle">Category</th>
                                            <th class="align-middle">Refund Method</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">
                                                {{ $hajjsavingPayment->reference }}
                                            </td>
                                            <td class="align-middle">
                                                {{ date('d-m-Y', strtotime($hajjsavingPayment->date)) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajj_saving->customer_name }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajj_saving->customer_phone }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($hajjsavingPayment->trx_type == 'Saving')
                                                    <span class="badge badge-success" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->trx_type }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->trx_type }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                {{ $hajjsavingPayment->payment_method }}
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <table class="table table-striped col-lg-6">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Refund Amount</th>
                                            <th class="align-middle">Refund Status</th>
                                            <th class="align-middle">Saving Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                                {{ format_currency($hajjsavingPayment->refund_amount) }}
                                            </td>
                                            <td class="align-middle">
                                                @if ($hajjsavingPayment->status == 'Verified')
                                                    <span class="badge badge-success" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->status }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger" style="font-size: 13px;">
                                                        {{ $hajjsavingPayment->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                                {{ format_currency($hajj_saving->total_saving) }}
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
                                            <td class="left"><strong>PT Marhaban Makkah Madinah</strong></td>
                                            {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"><strong>Direktur Utama</strong></td>
                                            {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <label for="savings">Refund Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                        @forelse($hajjsavingPayment->getMedia('savings') as $media)
                                            <img src="{{ $media->getUrl() }}" alt="Refund Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                        @empty
                                            <img src="{{ $hajjsavingPayment->getFirstMediaUrl('savings') }}" alt="Refund Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif

