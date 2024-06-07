@extends('layouts.app')

@section('title', 'Edit Rewards Settings')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Edit Rewards Settings</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Rewards Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="rewards-setting-form" action="{{ route('settings-rewards.update') }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level1_rewards">Bronze Rewards <span class="text-danger">*</span></label>
                                        <input id="level1_rewards" type="text" class="form-control" name="level1_rewards" value="{{ $settings->level1_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level4_rewards">Platinum Rewards <span class="text-danger">*</span></label>
                                        <input id="level4_rewards" type="text" class="form-control" name="level4_rewards" value="{{ $settings->level4_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal_rewards">Referal Rewards <span class="text-danger">*</span></label>
                                        <input id="referal_rewards" type="text" class="form-control" name="referal_rewards" value="{{ $settings->referal_rewards }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level2_rewards">Silver Rewards <span class="text-danger">*</span></label>
                                        <input id="level2_rewards" type="text" class="form-control" name="level2_rewards" value="{{ $settings->level2_rewards }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level3_rewards">Gold Rewards <span class="text-danger">*</span></label>
                                        <input id="level3_rewards" type="text" class="form-control" name="level3_rewards" value="{{ $settings->level3_rewards }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
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
            $('#referal_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level1_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level2_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level3_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level4_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#referal_rewards').maskMoney('mask');
            $('#level1_rewards').maskMoney('mask');
            $('#level2_rewards').maskMoney('mask');
            $('#level3_rewards').maskMoney('mask');
            $('#level4_rewards').maskMoney('mask');

            $('#rewards-setting-form').submit(function () {
                var referal_rewards = $('#referal_rewards').maskMoney('unmasked')[0];
                $('#referal_rewards').val(referal_rewards);
                var level1_rewards = $('#level1_rewards').maskMoney('unmasked')[0];
                $('#level1_rewards').val(level1_rewards);
                var level2_rewards = $('#level2_rewards').maskMoney('unmasked')[0];
                $('#level2_rewards').val(level2_rewards);
                var level3_rewards = $('#level3_rewards').maskMoney('unmasked')[0];
                $('#level3_rewards').val(level3_rewards);
                var level4_rewards = $('#level4_rewards').maskMoney('unmasked')[0];
                $('#level4_rewards').val(level4_rewards);
            });
        });
    </script>
@endpush
