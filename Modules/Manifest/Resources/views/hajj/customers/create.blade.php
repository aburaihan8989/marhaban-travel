@extends('layouts.app')

@section('title', 'Create Manifest Customer Hajj')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hajj-manifests.index') }}">Hajj Manifest Customers</a></li>
        <li class="breadcrumb-item active">Create Manifest Customer Hajj</li>
    </ol>
@endsection

@section('content')
{{-- @dd($umroh_manifest) --}}
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
                        <form id="hajj-manifest-customer-form" action="{{ route('hajj-manifest-customers.store', $hajj_manifest) }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required readonly value="CM">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                            <select class="form-control" name="customer_id" id="customer_id" required>
                                                @foreach(\Modules\People\Entities\Customer::all() as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <livewire:product-cart :cartInstance="'purchase'"/> --}}

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="total_price" type="text" class="form-control" name="total_price" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                            <select class="form-control" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Transfer">Transfer</option>
                                                <option value="QRIS">QRIS</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="last_amount">Payment Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="last_amount" type="text" class="form-control" name="last_amount" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Ticket Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="ticket" name="ticket" value="1">
                                      <label class="form-check-label" for="ticket">Completed</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Visa Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="visa" name="visa" value="1">
                                      <label class="form-check-label" for="visa">Completed</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Perlengkapan</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="big_suitcase" name="big_suitcase" value="1">
                                      <label class="form-check-label" for="big_suitcase">Big Suitcase</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_suitcase" name="small_suitcase" value="1">
                                      <label class="form-check-label" for="small_suitcase">Small Suitcase</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_bag" name="small_bag" value="1">
                                      <label class="form-check-label" for="small_bag">Small Bag</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="clothes" name="clothes" value="1">
                                      <label class="form-check-label" for="clothes">Ihram / Clothes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0"></legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_pillow" name="small_pillow" value="1">
                                      <label class="form-check-label" for="small_pillow">Small Pillow</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="scarf" name="scarf" value="1">
                                      <label class="form-check-label" for="scarf">Scarf</label>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <br>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Create Hajj Manifest <i class="bi bi-check"></i>
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
            $('#last_amount').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#total_price').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
                allowZero: true,
            });

            $('#hajj-manifest-customer-form').submit(function () {
                var last_amount = $('#last_amount').maskMoney('unmasked')[0];
                var total_price = $('#total_price').maskMoney('unmasked')[0];
                $('#last_amount').val(last_amount);
                $('#total_price').val(total_price);
            });
        });
    </script>
@endpush