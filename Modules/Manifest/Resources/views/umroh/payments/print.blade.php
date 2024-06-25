<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if ( $umroh_manifest_payment->trx_type == 'Payment')
        <title>Details Customer Umroh Payment Receipt</title>
    @else
        <title>Details Customer Umroh Refund Receipt</title>
    @endif
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="600" src="{{ public_path('images/logo-header_1.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px; font-size:17px;">
                    <span>ID Register :</span> <strong>{{ $umroh_manifest_payment->reference }}</strong></br></br>
                    @if ( $umroh_manifest_payment->trx_type == 'Payment')
                        <span>Category :</span> <strong>Customer Umroh Payment Receipt</strong>
                    @else
                        <span>Category :</span> <strong>Customer Umroh Refund Receipt</strong>
                    @endif
                </h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Travel Info:</h4>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>Phone: {{ settings()->company_phone }}</div>
                            <div>Email: {{ settings()->company_email }}</div>

                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Customer Info:</h4>
                            <div><strong>{{ $customer->customer_name }}</strong></div>
                            <div>{{ $customer->address }}</div>
                            <div>Phone: {{ $customer->customer_phone }}</div>
                            <div>Email: {{ $customer->customer_email }}</div>
                        </div>

                        <div class="col-xs-4 mb-3 mb-md-0">
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Agent Info:</h4>
                            {{-- <div><strong>{{ $customer->customer_name }}</strong></div>
                            <div>{{ $customer->address }}</div>
                            <div>Phone: {{ $customer->customer_phone }}</div>
                            <div>Email: {{ $customer->customer_email }}</div> --}}
                        </div>
                    </div>

                    @if ( $umroh_manifest_payment->trx_type == 'Payment')
                        <div class="table-responsive-sm" style="margin-top: 30px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">ID Reference</th>
                                        <th class="align-middle">Payment Date</th>
                                        <th class="align-middle">Customer Name</th>
                                        {{-- <th class="align-middle">Phone Number</th> --}}
                                        <th class="align-middle">Category</th>
                                        <th class="align-middle">Total Price</th>
                                        <th class="align-middle">Remaining Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $umroh_manifest_payment->reference }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ date('d-m-Y', strtotime($umroh_manifest_payment->date)) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $customer->customer_name }}
                                        </td>
                                        {{-- <td class="align-middle" style="font-size: 15px;">
                                            {{ $customer->customer_phone }}
                                        </td> --}}
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $umroh_manifest_payment->trx_type }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ format_currency($umroh_manifest_payment->umrohManifestCustomers->total_price) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ format_currency($umroh_manifest_payment->umrohManifestCustomers->remaining_payment) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row mb-4">
                                <div class="col-xs-8 mb-3 mb-md-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Payment Method</th>
                                                <th class="align-middle">Payment Amount</th>
                                                <th class="align-middle">Payment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                                    {{ $umroh_manifest_payment->payment_method }}
                                                </td>
                                                <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                                    {{ format_currency($umroh_manifest_payment->amount) }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($umroh_manifest_payment->status == 'Verified')
                                                        <span class="badge badge-success" style="font-size: 15px;">
                                                            {{ $umroh_manifest_payment->status }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger" style="font-size: 15px;">
                                                            {{ $umroh_manifest_payment->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive-sm" style="margin-top: 30px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">ID Reference</th>
                                        <th class="align-middle">Refund Date</th>
                                        <th class="align-middle">Customer Name</th>
                                        {{-- <th class="align-middle">Phone Number</th> --}}
                                        <th class="align-middle">Category</th>
                                        <th class="align-middle">Total Price</th>
                                        <th class="align-middle">Remaining Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $umroh_manifest_payment->reference }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ date('d-m-Y', strtotime($umroh_manifest_payment->date)) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $customer->customer_name }}
                                        </td>
                                        {{-- <td class="align-middle" style="font-size: 15px;">
                                            {{ $customer->customer_phone }}
                                        </td> --}}
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ $umroh_manifest_payment->trx_type }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ format_currency($umroh_manifest_payment->umrohManifestCustomers->total_price) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 15px;">
                                            {{ format_currency($umroh_manifest_payment->umrohManifestCustomers->remaining_payment) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row mb-4">
                                <div class="col-xs-8 mb-3 mb-md-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Refund Method</th>
                                                <th class="align-middle">Refund Amount</th>
                                                <th class="align-middle">Refund Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                                    {{ $umroh_manifest_payment->payment_method }}
                                                </td>
                                                <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                                    {{ format_currency($umroh_manifest_payment->refund_amount) }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($umroh_manifest_payment->status == 'Verified')
                                                        <span class="badge badge-success" style="font-size: 15px;">
                                                            {{ $umroh_manifest_payment->status }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger" style="font-size: 15px;">
                                                            {{ $umroh_manifest_payment->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8">
                            <table class="table border-0">
                                <tbody>
                                    <tr>
                                    <td class="left"><strong>PT {{ settings()->company_name }}</strong></td>
                                        {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;">
                                            <img width="180" src="{{ asset('images/sign.png') }}" alt="Sign">
                                        </td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"><strong>{{ settings()->sign_name }}</strong></td>
                                        {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ( $umroh_manifest_payment->trx_type == 'Payment')
                        <div class="col-lg-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <label for="payments">Payment Receipt<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label><br>
                                    @forelse($umroh_manifest_payment->getMedia('payments') as $media)
                                        <img src="{{ $media->getUrl() }}" alt="Payment Receipt" class="img-fluid img-thumbnail mb-2" style="width:200px;height:250px;">
                                    @empty
                                        <img src="{{ $umroh_manifest_payment->getFirstMediaUrl('payments') }}" alt="Payment Receipt" class="img-fluid img-thumbnail mb-2" style="width:200px;height:250px;">
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <label for="payments">Refund Receipt<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label><br>
                                    @forelse($umroh_manifest_payment->getMedia('payments') as $media)
                                        <img src="{{ $media->getUrl() }}" alt="Refund Receipt" class="img-fluid img-thumbnail mb-2" style="width:200px;height:250px;">
                                    @empty
                                        <img src="{{ $umroh_manifest_payment->getFirstMediaUrl('payments') }}" alt="Refund Receipt" class="img-fluid img-thumbnail mb-2" style="width:200px;height:250px;">
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row" style="margin-top: 50px;">
                        <div class="col-xs-12">
                            {{-- <p style="font-style: italic;text-align: center">{{ settings()->company_name }} | &copy; {{ date('Y') }}.</p> --}}
                            <div style="font-style: italic;text-align: center">Travel Management System ® {{ date('Y') }} || <strong><a target="_blank" href="#"><i>{{ settings()->company_name }} © Hajj & Umroh Service</i></a></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
