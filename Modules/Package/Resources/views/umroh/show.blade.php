@extends('layouts.app')

@section('title', 'Umroh Package Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-packages.index') }}">Umroh Packages</a></li>
        <li class="breadcrumb-item active">Umroh Package Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        {{-- <div class="row mb-3">
            <div class="col-md-12">
                {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($product->product_code, $product->product_barcode_symbology, 2, 110) !!}
            </div>
        </div> --}}
        <div class="row">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th>Package Code</th>
                                    <td>{{ $umroh_package->package_code }}</td>
                                </tr>
                                <tr>
                                    <th>Package Name</th>
                                    <td>{{ $umroh_package->package_name }}</td>
                                </tr>
                                <tr>
                                    <th>Package Departure</th>
                                    <td>{{ $umroh_package->package_departure }}</td>
                                </tr>
                                <tr>
                                    <th>Departure Date</th>
                                    <td>{{ date('d-m-Y', strtotime($umroh_package->package_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Package Days</th>
                                    <td>{{ $umroh_package->package_days . ' Days' }}</td>
                                </tr>
                                <tr>
                                    <th>Package Route</th>
                                    <td>{{ $umroh_package->flight_route }}</td>
                                </tr>
                                <tr>
                                    <th>Airline Name</th>
                                    <td>{{ $umroh_package->airline_name }}</td>
                                </tr>
                                <tr>
                                    <th>Available Seat</th>
                                    <td>{{ $umroh_package->package_capacity . ' Pax' }}</td>
                                </tr>
                                <tr>
                                    <th>Package Status</th>
                                    <td>
                                        @if($umroh_package->package_status == 'Active')
                                            <span class="badge badge-success" style="font-size: 13px;">
                                                {{ $umroh_package->package_status }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 13px;">
                                                {{ $umroh_package->package_status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Package Variant*1 <strong class="text-primary"><i>({{ $umroh_package->category }})</i></strong></th>
                                    <td>
                                        Hotel Makkah :: {{ $umroh_package->hotel_makkah }} <br>
                                        Hotel Madinah :: {{ $umroh_package->hotel_madinah }}
                                        <hr>
                                        Package Cost :: {{ format_currency($umroh_package->package_cost) }} <br>
                                        Package Price :: {{ format_currency($umroh_package->package_price) }}
                                        <hr>
                                        (+) Triple :: {{ format_currency($umroh_package->add_triple) }}  ||  (+) Double :: {{ format_currency($umroh_package->add_double) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Package Variant*2 <strong class="text-primary"><i>({{ $umroh_package->category_2 }})</i></strong></th>
                                    <td>
                                        Hotel Makkah :: {{ $umroh_package->hotel_makkah_2 }} <br>
                                        Hotel Madinah :: {{ $umroh_package->hotel_madinah_2 }}
                                        <hr>
                                        Package Cost :: {{ format_currency($umroh_package->package_cost_2) }} <br>
                                        Package Price :: {{ format_currency($umroh_package->package_price_2) }}
                                        <hr>
                                        (+) Triple :: {{ format_currency($umroh_package->add_triple_2) }}  ||  (+) Double :: {{ format_currency($umroh_package->add_double_2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <label for="brosur">Package Brosur <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        @forelse($umroh_package->getMedia('brosurs') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Package Brosur" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $umroh_package->getFirstMediaUrl('brosurs') }}" alt="Package Brosur" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th width="300px">Package Include</th>
                                    <td>
                                        <textarea rows="4" class="form-control" readonly>{{ $umroh_package->package_include }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th width="300px">Package Exclude</th>
                                    <td>
                                        <textarea rows="4" class="form-control" readonly>{{ $umroh_package->package_exclude }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th width="300px">Package Term & Conditions</th>
                                    <td>
                                        <textarea rows="4" class="form-control" readonly>{{ $umroh_package->package_term }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-9">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th width="300px">Note (If Needed)</th>
                                    <td>
                                        <textarea rows="4" class="form-control" readonly>{{ $umroh_package->note }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection



