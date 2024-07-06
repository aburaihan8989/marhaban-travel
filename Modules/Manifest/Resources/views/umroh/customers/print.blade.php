<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details Customer Manifest Umroh</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="600" src="{{ public_path('images/logo-header_1.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px; font-size:17px;">
                    <span>ID Register :</span> <strong>{{ $umroh_manifest_customer->reference }}</strong></br></br>
                    <span>Category :</span> <strong>Details Customer Manifest Umroh</strong>
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
                            <h4 class="mb-2" style="border-bottom: 1px solid #dddddd;padding-bottom: 10px;">Agent / Sponsor Info:</h5>
                            <div><strong>{{ $agent->agent_code . ' | ' . $agent->agent_name }}</strong></div>
                            <div>{{ $agent->address }}</div>
                            <div>Phone: {{ $agent->agent_phone }}</div>
                            <div>Email: {{ $agent->agent_email }}</div>
                    </div>
                    </div>

                    <div class="table-responsive-sm" style="margin-top: 20px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="align-middle">ID Register</th>
                                    <th class="align-middle">Register Date</th>
                                    <th class="align-middle">Customer Name</th>
                                    <th class="align-middle">Phone Number</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->reference }}
                                    </td>
                                    <td class="align-middle">
                                        {{ date('d-m-Y', strtotime($umroh_manifest_customer->register_date)) }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->customer_name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->customer_phone }}
                                    </td>
                            </tr>
                            </tbody>

                            <thead>
                                <tr>
                                    <th class="align-middle">Package Code</th>
                                    <th class="align-middle">Package Name</th>
                                    <th class="align-middle">Package Date</th>
                                    <th class="align-middle">Departure</th>
                                    <th class="align-middle">Days</th>
                                    <th class="align-middle">Group</th>
                                    <th class="align-middle">Package Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->umrohPackages->package_code }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->umrohPackages->package_name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ date('d-m-Y', strtotime($umroh_manifest_customer->umrohPackages->package_date)) }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->umrohPackages->package_departure }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->umrohPackages->package_days }} Days
                                    </td>
                                    <td class="align-middle">
                                        {{ $umroh_manifest_customer->room_group }}
                                    </td>
                                    <td class="align-middle">
                                        {{ format_currency($umroh_manifest_customer->total_price) }}
                                    </td>
                            </tr>
                            </tbody>

                            <thead>
                                <tr>
                                    <th class="align-middle">Total Price</th>
                                    <th class="align-middle">Total Payment</th>
                                    <th class="align-middle">Remaining Payment</th>
                                    <th class="align-middle">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                        {{ format_currency($umroh_manifest_customer->total_price) }}
                                    </td>
                                    <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                        {{ format_currency($umroh_manifest_customer->total_payment) }}
                                    </td>
                                    <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                        {{ format_currency($umroh_manifest_customer->remaining_payment) }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($umroh_manifest_customer->status == 'Completed')
                                            <span class="badge badge-success" style="font-size: 14px;">
                                                {{ $umroh_manifest_customer->status }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger" style="font-size: 14px;">
                                                {{ $umroh_manifest_customer->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

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

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0" style="font-size:17px">Ticket Status</legend>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->ticket == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:absolute;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="ticket">Issued</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:absolute;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="ticket">Process</label></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0" style="font-size:17px">Visa Status</legend>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->visa == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:absolute;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="visa">Issued</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:absolute;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="visa">Process</label></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0" style="font-size:17px">Perlengkapan</legend>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->big_suitcase == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="big_suitcase">Big Suitcase</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="big_suitcase">Big Suitcase</label></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->small_suitcase == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_suitcase">Small Suitcase</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_suitcase">Small Suitcase</label></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->small_bag == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_bag">Small Bag</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_bag">Small Bag</label></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->clothes == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="clothes">Clothes</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="clothes">Clothes</label></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->small_pillow == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_pillow">Small Pillow</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="small_pillow">Small Pillow</label></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                @if ($umroh_manifest_customer->scarf == '1')
                                    <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:20px;color:green;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="scarf">Scraf</label></i>
                                @else
                                    <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:20px;color:red;position:relative;top:-5px;"><label class="form-check-label ml-3" style="font-size:17px;position:relative;left:13px;" for="scarf">Scraf</label></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>

                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            {{-- <p style="font-style: italic;text-align: center">{{ settings()->company_name }} | &copy; {{ date('Y') }}.</p> --}}
                            <div style="font-style: italic;text-align: center">Travel Management System ® {{ date('Y') }} || <strong><a target="_blank" href="#"><i>Salsabila Wisata © Hajj & Umroh Service</i></a></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
