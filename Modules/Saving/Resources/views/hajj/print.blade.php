<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hajj Savings Details</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="600" src="{{ public_path('images/logo-header_1.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px; font-size:17px;">
                    <span>Register ID :</span> <strong>{{ $hajj_saving->reference }}</strong></br></br>
                    <span>Category :</span> <strong>Hajj Savings Details</strong>
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

                    <div class="table-responsive-sm" style="margin-top: 30px;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="align-middle">ID Reference</th>
                                <th class="align-middle">Register Date</th>
                                <th class="align-middle">Customer Name</th>
                                <th class="align-middle">Phone Number</th>
                                <th class="align-middle">Bank Name</th>
                                <th class="align-middle">Account Number</th>
                        </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ $hajj_saving->reference }}
                                </td>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ date('d-m-Y', strtotime($hajj_saving->register_date)) }}
                                </td>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ $hajj_saving->customer_name }}
                                </td>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ $hajj_saving->customer_phone }}
                                </td>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ $hajj_saving->customer_bank }}
                                </td>
                                <td class="align-middle" style="font-size: 15px;">
                                    {{ $hajj_saving->bank_account }}
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
                                        <span class="badge badge-success" style="font-size: 15px;">
                                            {{ $hajj_saving->status }}
                                        </span>
                                    </td>
                                    <td class="align-middle" style="font-size: 15px; font-weight: bold;">
                                        {{ format_currency($hajj_saving->total_saving) }}
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
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
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
