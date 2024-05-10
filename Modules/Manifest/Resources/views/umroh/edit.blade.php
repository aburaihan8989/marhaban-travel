@extends('layouts.app')

@section('title', 'Edit Umroh Manifest')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-manifests.index') }}">Umroh Manifest</a></li>
        <li class="breadcrumb-item active">Edit Manifest</li>
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
                        <form id="umroh-manifest-form" action="{{ route('umroh-manifests.update', $umroh_manifest) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $umroh_manifest->reference }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="package_id">Package Name <span class="text-danger">*</span></label>
                                            <select class="form-control" name="package_id" id="package_id" required>
                                                @foreach(\Modules\Package\Entities\UmrohPackage::all() as $umroh_package)
                                                    <option {{ $umroh_manifest->package_id == $umroh_package->id ? 'selected' : '' }} value="{{ $umroh_package->id }}">{{ $umroh_package->package_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Manifest Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="" selected>None</option>
                                            <option {{ $umroh_manifest->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                            <option {{ $umroh_manifest->status == 'Closed' ? 'selected' : '' }} value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $umroh_manifest->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Umroh Manifest <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
