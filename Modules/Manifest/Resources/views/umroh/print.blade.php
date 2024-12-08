<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Umroh Manifest Details</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center;margin-bottom: 25px;">
                <img width="600" src="{{ public_path('images/logo-header_1.png') }}" alt="Logo">
                <h4 style="margin-bottom: 20px; font-size:17px;">
                    <span>Register ID :</span> <strong>{{ $umroh_manifest->reference }}</strong></br></br>
                    <span>Category :</span> <strong>Umroh Manifest Details</strong>
                </h4>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <label for="brosurs">Package Manifest <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    @forelse($umroh_manifest->UmrohPackages->getMedia('brosurs') as $media)
                                        <img src="{{ $media->getUrl() }}" alt="Package Manifest" class="img-fluid img-thumbnail mb-2">
                                    @empty
                                        <img src="{{ $umroh_manifest->UmrohPackages->getFirstMediaUrl('brosurs') }}" alt="Package Manifest" class="img-fluid img-thumbnail mb-2">
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tr>
                                                <th>Reference</th>
                                                <td>{{ $umroh_manifest->reference }}</td>
                                            </tr>
                                            <tr>
                                                <th>Package Code</th>
                                                <td>{{ $umroh_manifest->package_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Date</th>
                                                <td>{{ date('d-m-Y', strtotime($umroh_manifest->package_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Package Name</th>
                                                <td>{{ $umroh_manifest->package_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure</th>
                                                <td>{{ $umroh_manifest->package_departure }}</td>
                                            </tr>
                                            <tr>
                                                <th>Package Route</th>
                                                <td>{{ $umroh_manifest->flight_route }}</td>
                                            </tr>
                                            <tr>
                                                <th>Package Days</th>
                                                <td>{{ $umroh_manifest->package_days . ' Days' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($umroh_manifest->status == 'Active')
                                                        <span class="badge badge-success" style="font-size: 13px;">
                                                            {{ $umroh_manifest->status }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary" style="font-size: 13px;">
                                                            {{ $umroh_manifest->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Package <strong class="text-primary"><i>({{ $umroh_manifest->umrohPackages->package_type }})</i></strong></th>
                                                <td>
                                                    Hotel Makkah :: {{ $umroh_manifest->umrohPackages->hotel_makkah }} <br>
                                                    Hotel Madinah :: {{ $umroh_manifest->umrohPackages->hotel_madinah }}
                                                    <hr>
                                                    Package Cost :: {{ format_currency($umroh_manifest->umrohPackages->package_cost) }} <br>
                                                    Package Price :: {{ format_currency($umroh_manifest->umrohPackages->package_price) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Package <strong class="text-primary"><i>({{ $umroh_manifest->umrohPackages->package_type_2 }})</i></strong></th>
                                                <td>
                                                    Hotel Makkah :: {{ $umroh_manifest->umrohPackages->hotel_makkah_2 }} <br>
                                                    Hotel Madinah :: {{ $umroh_manifest->umrohPackages->hotel_madinah_2 }}
                                                    <hr>
                                                    Package Cost :: {{ format_currency($umroh_manifest->umrohPackages->package_cost_2) }} <br>
                                                    Package Price :: {{ format_currency($umroh_manifest->umrohPackages->package_price_2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8">
                            <table class="table border-0">
                                <tbody>
                                    <tr>
                                    <td class="left"><strong>PT Marhaban Makkah Madinah</strong></td>
                                        {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0" style="border-top: none;"><strong>Direktur Utama</strong></td>
                                        {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            <div style="font-style: italic;text-align: center">Travel Management System ® {{ date('Y') }} || <strong><a target="_blank" href="#"><i>Marhaban Makkah Madinah © Hajj & Umroh Service</i></a></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
