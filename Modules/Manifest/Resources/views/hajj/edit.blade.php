@extends('layouts.app')

@section('title', 'Edit Hajj Manifest')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-manifests.index') }}">Hajj Manifest</a></li>
        <li class="breadcrumb-item active">Edit Hajj Manifest</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        {{-- <div class="row">
            <div class="col-12">
                <livewire:search-product/>
            </div>
        </div> --}}

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('utils.alerts')
                        <form id="hajj-manifest-form" action="{{ route('hajj-manifests.update', $hajj_manifest) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Manifest Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $hajj_manifest->reference }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="package_id">Package Name <span class="text-danger">*</span></label>
                                            <select class="form-control" name="package_id" id="package_id" required>
                                                <option value="" selected disabled>Select Package</option>
                                                @foreach(\Modules\Package\Entities\HajjPackage::all() as $hajj_package)
                                                    <option {{ $hajj_manifest->package_id == $hajj_package->id ? 'selected' : '' }} value="{{ $hajj_package->id }}">{{ $hajj_package->package_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Manifest Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="" selected>Select Status</option>
                                            <option {{ $hajj_manifest->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                            <option {{ $hajj_manifest->status == 'Flight' ? 'selected' : '' }} value="Flight">Flight</option>
                                            <option {{ $hajj_manifest->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $hajj_manifest->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Hajj Manifest <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
