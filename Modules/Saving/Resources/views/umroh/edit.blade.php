@extends('layouts.app')

@section('title', 'Edit Umroh Savings')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-savings.index') }}">Umroh Savings</a></li>
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
                        <form id="saving-form" action="{{ route('umroh-savings.update', $umroh_saving) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">ID Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $umroh_saving->reference }}" readonly>
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
                                                    <option {{ $umroh_saving->customer_id == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="customer_number">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="customer_number" required value="{{ $umroh_saving->customer_phone }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="register_date">Register Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="register_date" required value="{{ $umroh_saving->register_date }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="agent_id">Agent / Sponsor <span class="text-danger">*</span></label>
                                            <select class="form-control" name="agent_id" id="agent_id" required>
                                                <option value="" selected disabled>Select Agent / Sponsor</option>
                                                @foreach(\Modules\People\Entities\Agent::all() as $agent)
                                                    <option {{ $umroh_saving->agent_id == $agent->id ? 'selected' : '' }} value="{{ $agent->id }}">{{ $agent->agent_code . ' | ' . $agent->agent_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="agent_phone">Agent Phone Number <span class="text-danger"></span></label>
                                            @if ($umroh_saving->agent_id == '')
                                                <input type="text" class="form-control" name="agent_phone" value="" readonly>
                                            @else
                                                <input type="text" class="form-control" name="agent_phone" value="{{ $umroh_saving->umrohAgents->agent_phone }}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Savings Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option {{ $umroh_saving->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                            <option {{ $umroh_saving->status == 'Cancel' ? 'selected' : '' }} value="Cancel">Cancel</option>
                                            <option {{ $umroh_saving->status == 'Completed' ? 'selected' : '' }} value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="last_amount">Last Payment <span class="text-danger">*</span></label>
                                        <input id="last_amount" type="text" class="form-control" name="last_amount" required value="{{ format_currency($umroh_saving->last_amount) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="payment_method" required value="{{ $umroh_saving->payment_method }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="customer_bank">Account Name <span class="text-danger">*</span></label>
                                        <select class="form-control" name="customer_bank" id="customer_bank" required>
                                            <option {{ $umroh_saving->customer_bank == 'BSI' ? 'selected' : '' }} value="BSI">BSI</option>
                                            <option {{ $umroh_saving->customer_bank == 'BRI' ? 'selected' : '' }} value="BRI">BRI</option>
                                            <option {{ $umroh_saving->customer_bank == 'Mandiri' ? 'selected' : '' }} value="Mandiri">Mandiri</option>
                                            <option {{ $umroh_saving->customer_bank == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="bank_account">Account Number <span class="text-danger"></span></label>
                                        <input id="bank_account" type="text" class="form-control" name="bank_account" value="{{ $umroh_saving->bank_account }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="total_saving">Savings Balance <span class="text-danger"></span></label>
                                        <input id="total_saving" type="text" class="form-control" style="font-weight:bold; font-size:20px;" name="total_saving" value="{{ format_currency($umroh_saving->total_saving) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control">{{ $umroh_saving->note }}</textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Update Umroh Savings <i class="bi bi-check"></i>
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
    <script>
        $(document).ready(function() {
        console.log('');
        $('.select2').select2();
        });
   </script>
@endpush
