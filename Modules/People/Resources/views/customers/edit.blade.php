@extends('layouts.app')

@section('title', 'Edit Customer')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="customer-form" action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Update Customer <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nik_number">NIK Customer <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik_number" required value="{{ $customer->nik_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_name" required value="{{ $customer->customer_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="date_birth">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_birth" required value="{{ $customer->date_birth }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_phone">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_phone" required value="{{ $customer->customer_phone }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="paspor_number">Paspor Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="paspor_number" value="{{ $customer->paspor_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="paspor_date">Paspor Active <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="paspor_date" value="{{ $customer->paspor_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_status">Status Member <span class="text-danger">*</span></label>
                                        <select class="form-control" name="customer_status" id="customer_status">
                                            <option value="" selected>None</option>
                                            <option {{ $customer->customer_status == "Reguler" ? 'selected' : '' }} value="Reguler">Reguler</option>
                                            <option {{ $customer->customer_status == "Bronze" ? 'selected' : '' }} value="Bronze">Bronze</option>
                                            <option {{ $customer->customer_status == "Silver" ? 'selected' : '' }} value="Silver">Silver</option>
                                            <option {{ $customer->customer_status == "Gold" ? 'selected' : '' }} value="Gold">Gold</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="" selected>None</option>
                                            <option {{ $customer->gender == "L" ? 'selected' : '' }} value="L">Male</option>
                                            <option {{ $customer->gender == "P" ? 'selected' : '' }} value="P">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age_group">Age Group <span class="text-danger">*</span></label>
                                        <select class="form-control" name="age_group" id="age_group">
                                            <option value="" selected>None</option>
                                            <option {{ $customer->age_group == "A" ? 'selected' : '' }} value="A">Adult</option>
                                            <option {{ $customer->age_group == "K" ? 'selected' : '' }} value="K">Kids</option>
                                            <option {{ $customer->age_group == "I" ? 'selected' : '' }} value="I">Infant</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" required value="{{ $customer->city }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="country">Country <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="country" value="{{ $customer->country }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_email">Email <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="customer_email" value="{{ $customer->customer_email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" required value="{{ $customer->address }}">
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
                                <label for="photo">Photo Customer <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
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
            maxFiles: 1,
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
                @if(isset($customer) && $customer->getMedia('photos'))
                var files = {!! json_encode($customer->getMedia('photos')) !!};
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
@endpush
