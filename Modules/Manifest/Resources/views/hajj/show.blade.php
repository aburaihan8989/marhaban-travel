@extends('layouts.app')

@section('title', 'Details Hajj Manifest')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-manifests.index') }}">Hajj Manifest</a></li>
        <li class="breadcrumb-item active">Details Hajj Manifest</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Manifest Code : <strong>{{ $hajj_manifest->reference }}</strong>
                        </div>
                        {{-- <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('umroh-manifest-view.pdf', $umroh_manifest->id) }}" disabled> --}}
                        <a class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="#" disabled>
                            <i class="bi bi-printer"></i> Print
                        </a>
                        {{-- <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('umroh-manifest-view.pdf', $umroh_manifest->id) }}"> --}}
                        <a class="btn btn-sm btn-secondary mfe-1 d-print-none" href="#" disabled>
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Category : <strong>Details Hajj Manifest</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <label for="brosurs">Package Manifest <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        @forelse($hajj_manifest->HajjPackages->getMedia('brosurs') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Package Manifest" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $hajj_manifest->HajjPackages->getFirstMediaUrl('brosurs') }}" alt="Package Manifest" class="img-fluid img-thumbnail mb-2">
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
                                    <th>Manifest Code</th>
                                    <td>{{ $hajj_manifest->reference }}</td>
                                </tr>
                                <tr>
                                    <th>Package Code</th>
                                    <td>{{ $hajj_manifest->package_code }}</td>
                                </tr>
                                <tr>
                                    <th>Departure Date</th>
                                    <td>{{ date('d-m-Y', strtotime($hajj_manifest->HajjPackages->package_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Package Name</th>
                                    <td>{{ $hajj_manifest->HajjPackages->package_name }}</td>
                                </tr>
                                <tr>
                                    <th>Departure Location</th>
                                    <td>{{ $hajj_manifest->HajjPackages->package_departure }}</td>
                                </tr>
                                <tr>
                                    <th>Package Route</th>
                                    <td>{{ $hajj_manifest->HajjPackages->flight_route }}</td>
                                </tr>
                                <tr>
                                    <th>Airline Name</th>
                                    <td>{{ $hajj_manifest->hajjPackages->airline_name }}</td>
                                </tr>
                                <tr>
                                    <th>Package Days</th>
                                    <td>{{ $hajj_manifest->HajjPackages->package_days . ' Days' }}</td>
                                </tr>
                                <tr>
                                    <th>Package Status</th>
                                    <td>
                                        @if($hajj_manifest->HajjPackages->package_status == 'Active')
                                            <span class="badge badge-success" style="font-size: 15px;">
                                                {{ $hajj_manifest->HajjPackages->package_status }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 15px;">
                                                {{ $hajj_manifest->HajjPackages->package_status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Package Category</th>
                                    <td>{{ $hajj_manifest->hajjPackages->package_type }}</td>
                                </tr>
                                <tr>
                                    <th>Package Variant*1 <strong class="text-primary"><i>({{ $hajj_manifest->hajjPackages->category }})</i></strong></th>
                                    <td>
                                        Hotel Makkah :: {{ $hajj_manifest->hajjPackages->hotel_makkah }} <br>
                                        Hotel Madinah :: {{ $hajj_manifest->hajjPackages->hotel_madinah }}
                                        <hr>
                                        Hotel Transit :: {{ $hajj_manifest->hajjPackages->hotel_transit }} <br>
                                        Tenda Arafah :: {{ $hajj_manifest->hajjPackages->hotel_arafah }}
                                        <hr>
                                        Package Cost :: {{ format_currency($hajj_manifest->hajjPackages->package_cost) }} <br>
                                        Package Price :: {{ format_currency($hajj_manifest->hajjPackages->package_price) }}
                                        <hr>
                                        (+) Triple :: {{ format_currency($hajj_manifest->hajjPackages->add_triple) }} || (+) Double :: {{ format_currency($hajj_manifest->hajjPackages->add_double) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Package Variant*2 <strong class="text-primary"><i>({{ $hajj_manifest->hajjPackages->category_2 }})</i></strong></th>
                                    <td>
                                        Hotel Makkah :: {{ $hajj_manifest->hajjPackages->hotel_makkah_2 }} <br>
                                        Hotel Madinah :: {{ $hajj_manifest->hajjPackages->hotel_madinah_2 }}
                                        <hr>
                                        Hotel Transit :: {{ $hajj_manifest->hajjPackages->hotel_transit_2 }} <br>
                                        Tenda Arafah :: {{ $hajj_manifest->hajjPackages->hotel_arafah_2 }}
                                        <hr>
                                        Package Cost :: {{ format_currency($hajj_manifest->hajjPackages->package_cost_2) }} <br>
                                        Package Price :: {{ format_currency($hajj_manifest->hajjPackages->package_price_2) }}
                                        <hr>
                                        (+) Triple :: {{ format_currency($hajj_manifest->hajjPackages->add_triple_2) }} || (+) Double :: {{ format_currency($hajj_manifest->hajjPackages->add_double_2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Tables : <strong>Data List Customers Hajj Manifest</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive nowrap">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    {!! $dataTable->scripts() !!}
@endpush
