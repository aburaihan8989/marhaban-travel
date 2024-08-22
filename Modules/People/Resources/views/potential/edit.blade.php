@extends('layouts.app')

@section('title', 'Edit Potential Customer')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers-potential.data') }}">Data Potential Customers</a></li>
        <li class="breadcrumb-item active">Edit Potential Customer</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="edit-potential-form" action="{{ route('customers-potential.update', $customer->id) }}" method="POST">
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
                                        <label for="reference">ID Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $customer->reference }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="customer_name" required value="{{ $customer->customer_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_phone">Phone Number <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="customer_phone" value="{{ $customer->customer_phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="package_name">Customer Package <span class="text-danger"></span></label>
                                        <input type="text" class="form-control" name="package_name" value="{{ $customer->package_name }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="rating">Potential Poin <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="rating" required value="{{ $customer->rating }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fu_notes">Potential Follow Up Details</label>
                                <textarea class="form-control" rows="6" name="fu_notes">{{ $customer->fu_notes }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush
