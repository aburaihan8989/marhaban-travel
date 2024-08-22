@extends('layouts.app')

@section('title', 'Edit Prospek Customer')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers-prospek.data') }}">Data Prospek Customers</a></li>
        <li class="breadcrumb-item active">Edit Prospek Customer</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="customer-form" action="{{ route('customers-prospek.update', $customer['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
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
                                        <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_name" required value="{{ $customer['customer_name'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_phone">Phone Number <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="customer_phone" value="{{ $customer['customer_phone'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_email">Email <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="customer_email" value="{{ $customer['customer_email'] }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Gender <span class="text-danger"></span></label>
                                        <select class="form-control" name="gender" id="gender" readonly>
                                            <option value="" selected>None</option>
                                            <option {{ $customer['gender'] == "L" ? 'selected' : '' }} value="L">Male</option>
                                            <option {{ $customer['gender'] == "P" ? 'selected' : '' }} value="P">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" required value="{{ $customer['city'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="agent">Agent Name <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" value="{{ $customer['agent_code'] . ' | ' . $customer['agent_name'] }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Follow Up <span class="text-danger"></span></label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="" selected>None</option>
                                            <option {{ $customer['status'] == "FU" ? 'selected' : '' }} value="FU">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="address" value="{{ $customer['address'] }}" readonly>
                                    </div>
                                </div>

                                <input type="hidden" value="{{ $customer['agent_id'] }}" name="agent_id">
                                <input type="hidden" value="{{ $customer['agent_code'] }}" name="agent_code">
                                <input type="hidden" value="{{ $customer['agent_name'] }}" name="agent_name">

                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="rating">Prospek Poin <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="rating" required value="{{ $customer['rating'] }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fu_notes">Prospek Follow Up Details </label>
                                <textarea class="form-control" rows="6" name="fu_notes">{{ $customer['fu_notes'] }}</textarea>
                            </div>


                        </div>
                    </div>
                </div>
                {{-- // <div class="col-lg-12">
                //     <div class="card">
                //         <div class="card-body">
                //             <div class="form-group">
                //                 <label for="photo">Photo Customer <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
                //                 <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                //                     <div class="dz-message" data-dz-message>
                //                         <i class="bi bi-cloud-arrow-up"></i>
                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div> --}}
            </div>
        </form>
    </div>
@endsection

@section('third_party_scripts')
    {{-- // <script src="{{ asset('js/dropzone.js') }}"></script> --}}
@endsection

@push('page_scripts')
    {{-- // <script>
    //     var uploadedDocumentMap = {}
    //     Dropzone.options.documentDropzone = {
    //         url: '{{ route('dropzone.upload') }}',
    //         maxFilesize: 1,
    //         acceptedFiles: '.jpg, .jpeg, .png',
    //         maxFiles: 1,
    //         addRemoveLinks: true,
    //         dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
    //         headers: {
    //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
    //         },
    //         success: function (file, response) {
    //             $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
    //             uploadedDocumentMap[file.name] = response.name;
    //         },
    //         removedfile: function (file) {
    //             file.previewElement.remove();
    //             var name = '';
    //             if (typeof file.file_name !== 'undefined') {
    //                 name = file.file_name;
    //             } else {
    //                 name = uploadedDocumentMap[file.name];
    //             }
    //             $('form').find('input[name="document[]"][value="' + name + '"]').remove();
    //         },
    //         init: function () {
    //             @if(isset($customer) && $customer->getMedia('photos'))
    //             var files = {!! json_encode($customer->getMedia('photos')) !!};
    //             for (var i in files) {
    //                 var file = files[i];
    //                 this.options.addedfile.call(this, file);
    //                 this.options.thumbnail.call(this, file, file.original_url);
    //                 file.previewElement.classList.add('dz-complete');
    //                 $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
    //             }
    //             @endif
    //         }
    //     }
    // </script> --}}
@endpush
