@extends('layouts.app')

@section('title', 'Edit Customer Manifest Umroh')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id) }}">Manage Umroh Manifest</a></li>
        <li class="breadcrumb-item active">Edit Customer Manifest Umroh</li>
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
                                        <label for="reference">Reference ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $umroh_manifest_customer_id->reference }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_id">Customer Name <span class="text-danger">*</span></label>
                                            <select class="select2 form-control" name="customer_id" id="customer_id" required>
                                                <option value="" selected disabled>Select Customer</option>
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
                                            <label for="customer_phone">Customer Phone Number <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="customer_phone" value="{{ $umroh_manifest_customer_id->customer_phone }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="agent_id">Agent / Sponsor <span class="text-danger">*</span></label>
                                            <select class="form-control" name="agent_id" id="agent_id" required readonly disabled>
                                                <option value="" selected disabled>Select Agent / Sponsor</option>
                                                @foreach(\Modules\People\Entities\Agent::all() as $agent)
                                                    <option {{ $umroh_manifest_customer_id->agent_id == $agent->id ? 'selected' : '' }} value="{{ $agent->id }}">{{ $agent->agent_code . ' | ' . $agent->agent_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="agent_phone">Agent Phone Number <span class="text-danger"></span></label>
                                            @if ($umroh_manifest_customer_id->agent_id == '')
                                                <input type="text" class="form-control" name="agent_phone" value="" readonly>
                                            @else
                                                <input type="text" class="form-control" name="agent_phone" value="{{ $umroh_manifest_customer_id->umrohAgents->agent_phone }}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="room_group">Room Group <span class="text-danger">*</span></label>
                                        <select class="form-control" name="room_group" id="room_group" required>
                                            <option value="" selected>None</option>
                                            <option {{ $umroh_manifest_customer_id->room_group == "Quad" ? 'selected' : '' }} value="Quad">Quad</option>
                                            <option {{ $umroh_manifest_customer_id->room_group == "Triple" ? 'selected' : '' }} value="Triple">Triple</option>
                                            <option {{ $umroh_manifest_customer_id->room_group == "Double" ? 'selected' : '' }} value="Double">Double</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="family_group">Family Group <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="family_group" value="{{ $umroh_manifest_customer_id->family_group }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="baggage">Baggage <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" name="baggage" value="{{ $umroh_manifest_customer_id->baggage }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                        <input id="total_price" type="text" class="form-control" name="total_price" required value="{{ format_currency($umroh_manifest_customer_id->total_price) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <label for="total_payment">Total Payment <span class="text-danger"></span></label>
                                        <input id="total_payment" type="text" class="form-control" style="font-weight:bold;" name="total_payment" value="{{ format_currency($umroh_manifest_customer_id->total_payment) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="remaining_payment">Remaining Payment <span class="text-danger"></span></label>
                                        <input id="remaining_payment" type="text" class="form-control" style="font-weight:bold;" name="remaining_payment" value="{{ format_currency($umroh_manifest_customer_id->remaining_payment) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Special Program</legend>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="promo" name="promo" value="1" {{ $umroh_manifest_customer_id->promo == '1' ? 'checked' : '' }} readonly disabled>
                                      <label class="form-check-label" for="promo"><strong class="text-danger"><i>Full Promo</i></strong></label><span><i> ( If Selected, Fee and Referal Not Active)</i></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="promo2" name="promo2" value="1" {{ $umroh_manifest_customer_id->promo2 == '1' ? 'checked' : '' }} readonly disabled>
                                      <label class="form-check-label" for="promo2"><strong class="text-danger"><i>Limited Promo</i></strong></label><span><i> ( If Selected, Fee Limited and Referal Not Active )</i></span>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <br>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <i>
                                                <u><strong>Package Variant*1 </strong><strong class="text-primary"><i>({{ $umroh_manifest_customer_id->umrohPackages->category }})</i></strong></u>
                                                <br>
                                                <br>
                                                {{-- Package Cost :: {{ format_currency($umroh_manifest->umrohPackages->package_cost) }} --}}
                                                Package Price :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->package_price) }}
                                                <hr>
                                                (+) Triple :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->add_triple) }} || (+) Double :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->add_double) }}
                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <i>
                                                <u><strong>Package Variant*2 </strong><strong class="text-primary"><i>({{ $umroh_manifest_customer_id->umrohPackages->category_2 }})</i></strong></u>
                                                <br>
                                                <br>
                                                {{-- Package Cost :: {{ format_currency($umroh_manifest->umrohPackages->package_cost_2) }} --}}
                                                Package Price :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->package_price_2) }}
                                                <hr>
                                                (+) Triple :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->add_triple_2) }} || (+) Double :: {{ format_currency($umroh_manifest_customer_id->umrohPackages->add_double_2) }}
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Ticket Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="ticket" name="ticket" value="1" {{ $umroh_manifest_customer_id->ticket == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="ticket">Issued</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <legend class="col-form-label col-sm-2 pt-0">Visa Status</legend>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" id="visa" name="visa" value="1" {{ $umroh_manifest_customer_id->visa == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="visa">Issued</label>
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

                            <input type="hidden" value="{{ $umroh_manifest_customer_id->agent_id }}" name="agent_id">

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
    <script>
        $(document).ready(function() {
        console.log('');
        $('.select2').select2();
        });
   </script>
@endpush
