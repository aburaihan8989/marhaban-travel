@extends('layouts.app')

@section('title', 'Umroh Manifest Manages')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-manifests.index') }}">Umroh Manifest</a></li>
        <li class="breadcrumb-item active">Umroh Manifest Manages</li>
    </ol>
@endsection

@section('content')
{{-- @dd($umroh_manifest) --}}
    <div class="container-fluid mb-4">
        {{-- <div class="row mb-3">
            <div class="col-md-12">
                {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($product->product_code, $product->product_barcode_symbology, 2, 110) !!}
            </div>
        </div> --}}
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
                                    <th>Hotel Makkah</th>
                                    <td>{{ $umroh_manifest->UmrohPackages->hotel_makkah }}</td>
                                </tr>
                                <tr>
                                    <th>Hotel Madinah</th>
                                    <td>{{ $umroh_manifest->UmrohPackages->hotel_madinah }}</td>
                                </tr>
                                <tr>
                                    <th>Package Price</th>
                                    <td>{{ format_currency($umroh_manifest->UmrohPackages->package_price) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('umroh-manifest-customers.create', $umroh_manifest) }}" class="btn btn-primary">
                            Add Customer Manifest<i class="bi bi-plus"></i>
                        </a>

                        <hr>

                        <div id="tabel-manage" class="table-responsive">
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




