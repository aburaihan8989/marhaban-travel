@extends('layouts.app')

@section('title', 'Hotel Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
        <li class="breadcrumb-item active">Details</li>
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
                                    <th>Hotel Name</th>
                                    <td>{{ $hotel->hotel_name }}</td>
                                </tr>
                                <tr>
                                    <th>Hotel Location</th>
                                    <td>{{ $hotel->hotel_location }}</td>
                                </tr>
                                <tr>
                                    <th>Package Type</th>
                                    <td>{{ $hotel->package_type }}</td>
                                </tr>
                                <tr>
                                    <th>Hotel Price</th>
                                    <td>{{ format_currency($hotel->hotel_price) }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Stock Worth</th>
                                    <td>
                                        COST:: {{ format_currency($product->product_cost * $product->product_quantity) }} /
                                        PRICE:: {{ format_currency($product->product_price * $product->product_quantity) }}
                                    </td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <label for="hotels">Hotel Images <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        @forelse($hotel->getMedia('hotels') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Hotel Images" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $hotel->getFirstMediaUrl('hotels') }}" alt="Hotel Images" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



