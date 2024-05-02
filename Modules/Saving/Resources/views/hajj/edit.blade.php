@extends('layouts.app')

@section('title', 'Edit Hajj Savings')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-savings.index') }}">Hajj Savings</a></li>
        <li class="breadcrumb-item active">Edit</li>
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
                        <form id="hajj-saving-form" action="{{ route('hajj-savings.update', $hajj_saving) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $hajj_saving->reference }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_id">Customer Name <span class="text-danger">*</span></label>
                                            <select class="form-control" name="customer_id" id="customer_id" required>
                                                @foreach(\Modules\People\Entities\Customer::all() as $customer)
                                                    <option {{ $hajj_saving->customer_id == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_number">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="customer_number" required value="{{ $hajj_saving->customer_phone }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="register_date">Register Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="register_date" required value="{{ $hajj_saving->register_date }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <livewire:product-cart :cartInstance="'purchase'" :data="$purchase"/> --}}

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option {{ $hajj_saving->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                            <option {{ $hajj_saving->status == 'Cancel' ? 'selected' : '' }} value="Cancel">Cancel</option>
                                            <option {{ $hajj_saving->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="last_amount">Last Payment <span class="text-danger">*</span></label>
                                        <input id="last_amount" type="text" class="form-control" name="last_amount" required value="{{ format_currency($hajj_saving->last_amount) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="payment_method" required value="{{ $hajj_saving->payment_method }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_saving">Savings Balance <span class="text-danger">*</span></label>
                                        <input id="total_saving" type="text" class="form-control" style="font-weight:bold; font-size:20px;" name="total_saving" required value="{{ format_currency($hajj_saving->total_saving) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $hajj_saving->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Hajj Savings <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {
            // $('#last_amount').maskMoney({
            //     prefix:'{{ settings()->currency->symbol }}',
            //     thousands:'{{ settings()->currency->thousand_separator }}',
            //     decimal:'{{ settings()->currency->decimal_separator }}',
            //     allowZero: true,
            // });

            // $('#paid_amount').maskMoney('mask');

            // $('#saving-form').submit(function () {
            //     var last_amount = $('#last_amount').maskMoney('unmasked')[0];
            //     $('#last_amount').val(last_amount);
            // });
        });
    </script>
@endpush
