@extends('layouts.app')

@section('title', 'Edit Umroh Manifest Customer')
{{-- @dd($umroh_manifest_customer_id) --}}
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id) }}">Umroh Manifest Manages</a></li>
        <li class="breadcrumb-item active">Edit Manifest Customer</li>
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
                        <form id="umroh-manifest-customer-form" action="{{ route('umroh-manifest-customers.update', $umroh_manifest_customer_id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $umroh_manifest_customer_id->reference }}" readonly>
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
                                                    <option {{ $umroh_manifest_customer_id->customer_id == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_phone">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="customer_phone" required value="{{ $umroh_manifest_customer_id->customer_phone }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <livewire:product-cart :cartInstance="'purchase'" :data="$purchase"/> --}}

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                        <input id="total_price" type="text" class="form-control" name="total_price" required value="{{ format_currency($umroh_manifest_customer_id->total_price) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <label for="total_payment">Total Payment <span class="text-danger">*</span></label>
                                        <input id="total_payment" type="text" class="form-control" name="total_payment" required value="{{ format_currency($umroh_manifest_customer_id->total_payment) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- <div class="col-lg-4">
                                    <div class="from-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <input id="status" type="text" class="form-control" name="status" required value="{{ $umroh_manifest_customer_id->status }}">
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="remaining_payment">Remaining Payment <span class="text-danger">*</span></label>
                                        <input id="remaining_payment" type="text" class="form-control" style="font-weight:bold; font-size:20px;" name="remaining_payment" required value="{{ format_currency($umroh_manifest_customer_id->remaining_payment) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Ticket Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="ticket" name="ticket" value="1" {{ $umroh_manifest_customer_id->ticket == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="ticket">Completed</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Visa Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="visa" name="visa" value="1" {{ $umroh_manifest_customer_id->visa == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="visa">Completed</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Perlengkapan</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="big_suitcase" name="big_suitcase" value="1" {{ $umroh_manifest_customer_id->big_suitcase == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="big_suitcase">Big Suitcase</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_suitcase" name="small_suitcase" value="1" {{ $umroh_manifest_customer_id->small_suitcase == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="small_suitcase">Small Suitcase</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_bag" name="small_bag" value="1" {{ $umroh_manifest_customer_id->small_bag == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="small_bag">Small Bag</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="clothes" name="clothes" value="1" {{ $umroh_manifest_customer_id->clothes == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="clothes">Ihram / Clothes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0"></legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="small_pillow" name="small_pillow" value="1" {{ $umroh_manifest_customer_id->small_pillow == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="small_pillow">Small Pillow</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="scarf" name="scarf" value="1" {{ $umroh_manifest_customer_id->scarf == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="scarf">Scarf</label>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <br>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $umroh_manifest_customer_id->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Manifest Customer <i class="bi bi-check"></i>
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
            $('#total_price').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#total_payment').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#remaining_payment').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#total_price').maskMoney('mask');
            $('#total_payment').maskMoney('mask');
            $('#remaining_payment').maskMoney('mask');

            $('#umroh-manifest-customer-form').submit(function () {
                var total_price = $('#total_price').maskMoney('unmasked')[0];
                var total_payment = $('#total_payment').maskMoney('unmasked')[0];
                var remaining_payment = total_price - total_payment;
                $('#total_price').val(total_price);
                $('#total_payment').val(total_payment);
                $('#remaining_payment').val(remaining_payment);
                // $('#ticket').ticket;
            });
        });
    </script>
@endpush
