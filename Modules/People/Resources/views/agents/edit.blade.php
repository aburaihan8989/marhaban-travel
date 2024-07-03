@extends('layouts.app')

@section('title', 'Edit Agent')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
        <li class="breadcrumb-item active">Edit Agent</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="agent-form" action="{{ route('agents.update', $agent) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Update Agent <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="agent_code">Agent Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="agent_code" required readonly value="{{ $agent->agent_code }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nik_number">NIK Agent <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik_number" required value="{{ $agent->nik_number }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="agent_name">Agent Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="agent_name" required value="{{ $agent->agent_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="date_birth">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_birth" required value="{{ $agent->date_birth }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="" selected>None</option>
                                            <option {{ $agent->gender == "L" ? 'selected' : '' }} value="L">Male</option>
                                            <option {{ $agent->gender == "P" ? 'selected' : '' }} value="P">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="agent_phone">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="agent_phone" required value="{{ $agent->agent_phone }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="level_agent">Agent Level <span class="text-danger">*</span></label>
                                        <select class="form-control" name="level_agent" id="level_agent" required>
                                            <option value="" selected>Select Agent Level</option>
                                            <option {{ $agent->level_agent == "Bronze" ? 'selected' : '' }} value="Bronze">Bronze</option>
                                            <option {{ $agent->level_agent == "Silver" ? 'selected' : '' }} value="Silver">Silver</option>
                                            <option {{ $agent->level_agent == "Gold" ? 'selected' : '' }} value="Gold">Gold</option>
                                            <option {{ $agent->level_agent == "Platinum" ? 'selected' : '' }} value="Platinum">Platinum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="agent_status">Agent Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="agent_status" id="agent_status" required>
                                            <option value="" selected>Select Status Agent</option>
                                            <option {{ $agent->agent_status == "Active" ? 'selected' : '' }} value="Active">Active</option>
                                            <option {{ $agent->agent_status == "Closed" ? 'selected' : '' }} value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="referal_id">Referal Name <span class="text-danger"></span></label>
                                            <select class="select2 form-control" name="referal_id" id="referal_id" required>
                                                <option value="" selected disabled>Select Referal Name</option>
                                                @foreach(\Modules\People\Entities\Agent::all() as $agent_referal)
                                                    <option {{ $agent->referal_id == $agent_referal->id ? 'selected' : '' }} value="{{ $agent_referal->id }}">{{ $agent_referal->agent_code . ' | ' . $agent_referal->agent_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="referal_level">Referal Level <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="referal_level" readonly value="{{ $referal_agent->level_agent }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city" required value="{{ $agent->city }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="country">Country <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="country" value="{{ $agent->country }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="agent_email">Email <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="agent_email" value="{{ $agent->agent_email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" required value="{{ $agent->address }}">
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
                                <label for="agents">Photo Agent <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
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
                @if(isset($agent) && $agent->getMedia('agents'))
                var files = {!! json_encode($agent->getMedia('agents')) !!};
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
    <script>
        $(document).ready(function() {
        console.log('');
        $('.select2').select2();
        });
   </script>
@endpush
