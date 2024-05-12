@extends('layouts.app')

@section('title', 'Hajj Package Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-packages.index') }}">Hajj Packages</a></li>
        <li class="breadcrumb-item active">Hajj Package Details</li>
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
                                    <td>{{ $hajj_package->package_code }}</td>
                                </tr>
                                <tr>
                                    <th>Package Name</th>
                                    <td>{{ $hajj_package->package_name }}</td>
                                </tr>
                                <tr>
                                    <th>Package Departure</th>
                                    <td>{{ $hajj_package->package_departure }}</td>
                                </tr>
                                <tr>
                                    <th>Departure Date</th>
                                    <td>{{ date('d-m-Y', strtotime($hajj_package->package_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Package Days</th>
                                    <td>{{ $hajj_package->package_days . ' Days' }}</td>
                                </tr>
                                <tr>
                                    <th>Package Route</th>
                                    <td>{{ $hajj_package->flight_route }}</td>
                                </tr>
                                <tr>
                                    <th>Package Type</th>
                                    <td>{{ $hajj_package->package_type }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Stock Worth</th>
                                    <td>
                                        COST:: {{ format_currency($product->product_cost * $product->product_quantity) }} /
                                        PRICE:: {{ format_currency($product->product_price * $product->product_quantity) }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>Package Capacity</th>
                                    <td>{{ $hajj_package->package_capacity . ' Pax' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Hotel Makkah</th>
                                    <td>{{ $umroh_package->hotel_makkah ?? 'N/A' }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Hotel Makkah</th>
                                    <td>{{ $hajj_package->hotel_makkah }}</td>
                                </tr>
                                <tr>
                                    <th>Hotel Madinah</th>
                                    <td>{{ $hajj_package->hotel_madinah }}</td>
                                </tr>
                                <tr>
                                    <th>Package Status</th>
                                    <td>
                                        @if($hajj_package->package_status == 'Active')
                                            <span class="badge badge-success" style="font-size: 13px;">
                                                {{ $hajj_package->package_status }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 13px;">
                                                {{ $hajj_package->package_status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Package Cost</th>
                                    <td>{{ format_currency($hajj_package->package_cost) }}</td>
                                </tr>
                                <tr>
                                    <th>Package Price</th>
                                    <td>{{ format_currency($hajj_package->package_price) }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Tax Type</th>
                                    <td>
                                        @if($product->product_tax_type == 1)
                                            Exclusive
                                        @elseif($product->product_tax_type == 2)
                                            Inclusive
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr> --}}
                                {{-- <tr>
                                    <th>Note</th>
                                    <td>{{ $product->product_note ?? 'N/A' }}</td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <label for="brosur">Package Brosur <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        @forelse($hajj_package->getMedia('brosurs') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Package Brosur" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $hajj_package->getFirstMediaUrl('brosurs') }}" alt="Package Brosur" class="img-fluid img-thumbnail mb-2">
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
                                        <textarea rows="4" class="form-control" readonly>{{ $hajj_package->package_include }}</textarea>
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
                                        <textarea rows="4" class="form-control" readonly>{{ $hajj_package->package_exclude }}</textarea>
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
                                        <textarea rows="4" class="form-control" readonly>{{ $hajj_package->package_term }}</textarea>
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



