@extends('layouts.app')

@section('title', 'Edit Hotel')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <form id="hotel-form" action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Update Hotel <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hotel_name">Hotel Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="hotel_name" required value="{{ $hotel->hotel_name }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hotel_location">Hotel Location <span class="text-danger">*</span></label>
                                        <select class="form-control" name="hotel_location" id="hotel_location" required>
                                            <option value="" selected>None</option>
                                            <option {{ $hotel->hotel_location == 'Makkah' ? 'selected' : '' }} value="Makkah">Makkah</option>
                                            <option {{ $hotel->hotel_location == 'Madinah' ? 'selected' : '' }} value="Madinah">Madinah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact">Contact <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="contact" required value="{{ $hotel->contact }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" required value="{{ $hotel->email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package_type">Package Type <span class="text-danger">*</span></label>
                                        <select class="form-control" name="package_type" id="package_type">
                                            <option value="" selected>None</option>
                                            <option {{ $hotel->package_type == 'Marhaban' ? 'selected' : '' }} value="Marhaban">Marhaban</option>
                                            <option {{ $hotel->package_type == 'Muzdalifah' ? 'selected' : '' }} value="Muzdalifah">Muzdalifah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hotel_price">Hotel Price <span class="text-danger">*</span></label>
                                        <input id="hotel_price" type="text" class="form-control" name="hotel_price" required value="{{ format_currency($hotel->hotel_price) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="hotels">Hotel Images <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
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
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
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
                $('form').find('input[name="document[]"][value="' + name + '"]').remove();
            },
            init: function () {
                @if(isset($hotel) && $hotel->getMedia('hotels'))
                var files = {!! json_encode($hotel->getMedia('hotels')) !!};
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
            // $('#package_cost').maskMoney({
            //     prefix:'{{ settings()->currency->symbol }}',
            //     thousands:'{{ settings()->currency->thousand_separator }}',
            //     decimal:'{{ settings()->currency->decimal_separator }}',
            // });
            $('#hotel_price').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            // $('#package_cost').maskMoney('mask');
            $('#hotel_price').maskMoney('mask');

            $('#hotel-form').submit(function () {
                // var package_cost = $('#package_cost').maskMoney('unmasked')[0];
                var hotel_price = $('#hotel_price').maskMoney('unmasked')[0];
                // $('#package_cost').val(package_cost);
                $('#hotel_price').val(hotel_price);
            });
        });
    </script>
@endpush

