@extends('layouts.app')

@section('title', 'Create Hajj Package')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-packages.index') }}">Hajj Packages</a></li>
        <li class="breadcrumb-item active">Create Hajj Package</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="hajj-package-form" action="{{ route('hajj-packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Create Hajj Package <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_code">Package Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="package_code" required readonly value="HP">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_name">Package Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="package_name" required value="{{ old('package_name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_departure">Package Departure <span class="text-danger">*</span></label>
                                        <select class="form-control" name="package_departure" id="package_departure" required>
                                            <option value="" selected disabled>Select Departure</option>
                                            <option value="Makasar">Makasar</option>
                                            <option value="Jakarta">Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="package_date">Departure Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="package_date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_days">Package Days <span class="text-danger">*</span></label>
                                        <input id="package_days" type="text" class="form-control" name="package_days" required value="{{ old('package_days') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="flight_route">Package Route <span class="text-danger">*</span></label>
                                        <select class="form-control" name="flight_route" id="flight_route" required>
                                            <option value="" selected disabled>Select Route</option>
                                            <option value="Direct">Direct</option>
                                            <option value="Transit">Transit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_capacity">Available Seat <span class="text-danger">*</span></label>
                                        <input id="package_capacity" type="text" class="form-control" name="package_capacity" value="{{ old('package_capacity') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_status">Package Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="package_status" id="package_status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="airline_name">Airline Name<span class="text-danger">*</span></label>
                                            <select class="form-control" name="airline_name" id="airline_name" required>
                                                <option value="" selected disabled>Select Airline</option>
                                                @foreach(\Modules\Package\Entities\Airline::all() as $airline)
                                                    <option value="{{ $airline->airline_name }}">{{ $airline->airline_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_type">Package Category <span class="text-danger">*</span></label>
                                        <select class="form-control" name="package_type" id="package_type" required>
                                            <option value="" selected disabled>Select Category</option>
                                            <option value="Haji Domestik">Haji Domestik</option>
                                            <option value="Haji Khusus">Haji Khusus</option>
                                            <option value="ONH Plus Percepatan">ONH Plus Percepatan</option>
                                            <option value="ONH Plus">ONH Plus</option>
                                            <option value="Furoda">Furoda</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Package Category <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                        <input type="text" class="form-control" name="category" value="{{ old('category') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_makkah">Hotel Makkah <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                            <select class="form-control" name="hotel_makkah" id="hotel_makkah" required>
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_madinah">Hotel Madinah <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                            <select class="form-control" name="hotel_madinah" id="hotel_madinah" required>
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_transit">Hotel Transit <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                            <select class="form-control" name="hotel_transit" id="hotel_transit" required>
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_arafah">Tenda Arafah <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                            <select class="form-control" name="hotel_arafah" id="hotel_arafah" required>
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_cost">Package Cost <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                        <input id="package_cost" type="text" class="form-control" name="package_cost" value="{{ old('package_cost') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_price">Package Price <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                        <input id="package_price" type="text" class="form-control" name="package_price" required value="{{ old('package_price') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="add_triple">(+) Triple <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                        <input id="add_triple" type="text" class="form-control" name="add_triple" value="{{ old('add_triple') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="add_double">(+) Double <strong class="text-danger"><i>(Variant*1)</i></strong></label>
                                        <input id="add_double" type="text" class="form-control" name="add_double" value="{{ old('add_double') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_2">Package Category <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                        <input type="text" class="form-control" name="category_2" value="{{ old('category_2') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_makkah_2">Hotel Makkah <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                            <select class="form-control" name="hotel_makkah_2" id="hotel_makkah_2">
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_madinah_2">Hotel Madinah <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                            <select class="form-control" name="hotel_madinah_2" id="hotel_madinah_2">
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_transit_2">Hotel Transit <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                            <select class="form-control" name="hotel_transit_2" id="hotel_transit_2">
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="hotel_arafah_2">Tenda Arafah <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                            <select class="form-control" name="hotel_arafah_2" id="hotel_arafah_2">
                                                <option value="" selected disabled>Select Hotel</option>
                                                @foreach(\Modules\Package\Entities\Hotel::all() as $hotel)
                                                    <option value="{{ $hotel->hotel_name }}">{{ $hotel->hotel_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_cost_2">Package Cost <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                        <input id="package_cost_2" type="text" class="form-control" name="package_cost_2" value="{{ old('package_cost_2') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_price_2">Package Price <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                        <input id="package_price_2" type="text" class="form-control" name="package_price_2" value="{{ old('package_price_2') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="add_triple_2">(+) Triple <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                        <input id="add_triple_2" type="text" class="form-control" name="add_triple_2" value="{{ old('add_triple_2') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="add_double_2">(+) Double <strong class="text-primary"><i>(Variant*2)</i></strong></label>
                                        <input id="add_double_2" type="text" class="form-control" name="add_double_2" value="{{ old('add_double_2') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="package_include">Package Include </label>
                                <textarea name="package_include" id="package_include" rows="4 " class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="package_exclude">Package Exclude </label>
                                <textarea name="package_exclude" id="package_exclude" rows="4 " class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="package_term">Package Term & Condition </label>
                                <textarea name="package_term" id="package_term" rows="4 " class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="brosur">Package Brosur <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                    <div class="dz-message" data-dz-message>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

{{-- @include('product::includes.category-modal') --}}
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection

@push('page_scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('dropzone.upload') }}',
            maxFilesize: 1,
            acceptedFiles: '.jpg, .jpeg, .png',
            maxFiles: 3,
            addRemoveLinks: true,
            dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                uploadedDocumentMap[file.name] = response.name;
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name;
                } else {
                    name = uploadedDocumentMap[file.name];
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('dropzone.delete') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'file_name': `${name}`
                    },
                });
                $('form').find('input[name="document[]"][value="' + name + '"]').remove();
            },
            init: function () {
                @if(isset($hajj_package) && $hajj_package->getMedia('brosurs'))
                var files = {!! json_encode($hajj_package->getMedia('brosurs')) !!};
                for (var i in files) {
                    var file = files[i];
                    this.options.addedfile.call(this, file);
                    this.options.thumbnail.call(this, file, file.original_url);
                    file.previewElement.classList.add('dz-complete');
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                }
                @endif
            }
        }
    </script>

    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#package_cost').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#package_price').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#add_triple').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#add_double').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#package_cost_2').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#package_price_2').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#add_triple_2').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#add_double_2').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });


            $('#hajj-package-form').submit(function () {
                var package_cost = $('#package_cost').maskMoney('unmasked')[0];
                var package_price = $('#package_price').maskMoney('unmasked')[0];
                var add_triple = $('#add_triple').maskMoney('unmasked')[0];
                var add_double = $('#add_double').maskMoney('unmasked')[0];
                $('#package_cost').val(package_cost);
                $('#package_price').val(package_price);
                $('#add_triple').val(add_triple);
                $('#add_double').val(add_double);

                var package_cost_2 = $('#package_cost_2').maskMoney('unmasked')[0];
                var package_price_2 = $('#package_price_2').maskMoney('unmasked')[0];
                var add_triple_2 = $('#add_triple_2').maskMoney('unmasked')[0];
                var add_double_2 = $('#add_double_2').maskMoney('unmasked')[0];
                $('#package_cost_2').val(package_cost_2);
                $('#package_price_2').val(package_price_2);
                $('#add_triple_2').val(add_triple_2);
                $('#add_double_2').val(add_double_2);
            });
        });
    </script>
@endpush

