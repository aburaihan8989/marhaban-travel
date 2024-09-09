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
                        <h5 class="mb-0">Rewards Settings Umroh</h5>
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
                                        <label for="referal1_rewards">Referal Bronze <span class="text-danger">*</span></label>
                                        <input id="referal1_rewards" type="text" class="form-control" name="referal1_rewards" value="{{ $settings->referal1_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="promo_umroh">Referal Promo Umroh <span class="text-danger">*</span></label>
                                        <input id="promo_umroh" type="text" class="form-control" name="promo_umroh" value="{{ $settings->promo_umroh }}" required>
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal2_rewards">Referal Silver <span class="text-danger">*</span></label>
                                        <input id="referal2_rewards" type="text" class="form-control" name="referal2_rewards" value="{{ $settings->referal2_rewards }}" required>
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal3_rewards">Referal Gold <span class="text-danger">*</span></label>
                                        <input id="referal3_rewards" type="text" class="form-control" name="referal3_rewards" value="{{ $settings->referal3_rewards }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level4_rewards">Platinum Rewards <span class="text-danger">*</span></label>
                                        <input id="level4_rewards" type="text" class="form-control" name="level4_rewards" value="{{ $settings->level4_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal4_rewards">Referal Platinum <span class="text-danger">*</span></label>
                                        <input id="referal4_rewards" type="text" class="form-control" name="referal4_rewards" value="{{ $settings->referal4_rewards }}" required>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Rewards Settings Hajj</h5>
                    </div>
                    <div class="card-body">
                        <form id="rewards-hajj-setting-form" action="{{ route('settings-rewards-hajj.update') }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level11_rewards">Bronze Rewards <span class="text-danger">*</span></label>
                                        <input id="level11_rewards" type="text" class="form-control" name="level11_rewards" value="{{ $settings->level11_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal11_rewards">Referal Rewards <span class="text-danger">*</span></label>
                                        <input id="referal11_rewards" type="text" class="form-control" name="referal11_rewards" value="{{ $settings->referal11_rewards }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="promo_haji">Referal Promo Haji <span class="text-danger">*</span></label>
                                        <input id="promo_haji" type="text" class="form-control" name="promo_haji" value="{{ $settings->promo_haji }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level22_rewards">Silver Rewards <span class="text-danger">*</span></label>
                                        <input id="level22_rewards" type="text" class="form-control" name="level22_rewards" value="{{ $settings->level22_rewards }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal22_rewards">Referal Silver <span class="text-danger">*</span></label>
                                        <input id="referal22_rewards" type="text" class="form-control" name="referal22_rewards" value="{{ $settings->referal22_rewards }}" required>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level33_rewards">Gold Rewards <span class="text-danger">*</span></label>
                                        <input id="level33_rewards" type="text" class="form-control" name="level33_rewards" value="{{ $settings->level33_rewards }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal33_rewards">Referal Gold <span class="text-danger">*</span></label>
                                        <input id="referal33_rewards" type="text" class="form-control" name="referal33_rewards" value="{{ $settings->referal33_rewards }}" required>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="level44_rewards">Platinum Rewards <span class="text-danger">*</span></label>
                                        <input id="level44_rewards" type="text" class="form-control" name="level44_rewards" value="{{ $settings->level44_rewards }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="referal44_rewards">Referal Platinum <span class="text-danger">*</span></label>
                                        <input id="referal44_rewards" type="text" class="form-control" name="referal44_rewards" value="{{ $settings->referal44_rewards }}" required>
                                    </div>
                                </div> --}}
                            </div>
                            <br>

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
            $('#referal1_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#referal2_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#referal3_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#referal4_rewards').maskMoney({
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

            $('#referal11_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#promo_umroh').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#promo_haji').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            // $('#referal44_rewards').maskMoney({
            //     prefix:'{{ settings()->currency->symbol }}',
            //     thousands:'{{ settings()->currency->thousand_separator }}',
            //     decimal:'{{ settings()->currency->decimal_separator }}',
            // });

            $('#level11_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level22_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level33_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });
            $('#level44_rewards').maskMoney({
                prefix:'{{ settings()->currency->symbol }}',
                thousands:'{{ settings()->currency->thousand_separator }}',
                decimal:'{{ settings()->currency->decimal_separator }}',
            });

            $('#referal1_rewards').maskMoney('mask');
            $('#referal2_rewards').maskMoney('mask');
            $('#referal3_rewards').maskMoney('mask');
            $('#referal4_rewards').maskMoney('mask');

            $('#level1_rewards').maskMoney('mask');
            $('#level2_rewards').maskMoney('mask');
            $('#level3_rewards').maskMoney('mask');
            $('#level4_rewards').maskMoney('mask');

            $('#referal11_rewards').maskMoney('mask');
            $('#promo_umroh').maskMoney('mask');
            $('#promo_haji').maskMoney('mask');
            // $('#referal4_rewards').maskMoney('mask');

            $('#level11_rewards').maskMoney('mask');
            $('#level22_rewards').maskMoney('mask');
            $('#level33_rewards').maskMoney('mask');
            $('#level44_rewards').maskMoney('mask');

            $('#rewards-setting-form').submit(function () {
                var referal1_rewards = $('#referal1_rewards').maskMoney('unmasked')[0];
                $('#referal1_rewards').val(referal1_rewards);
                var referal2_rewards = $('#referal2_rewards').maskMoney('unmasked')[0];
                $('#referal2_rewards').val(referal2_rewards);
                var referal3_rewards = $('#referal3_rewards').maskMoney('unmasked')[0];
                $('#referal3_rewards').val(referal3_rewards);
                var referal4_rewards = $('#referal4_rewards').maskMoney('unmasked')[0];
                $('#referal4_rewards').val(referal4_rewards);

                var level1_rewards = $('#level1_rewards').maskMoney('unmasked')[0];
                $('#level1_rewards').val(level1_rewards);
                var level2_rewards = $('#level2_rewards').maskMoney('unmasked')[0];
                $('#level2_rewards').val(level2_rewards);
                var level3_rewards = $('#level3_rewards').maskMoney('unmasked')[0];
                $('#level3_rewards').val(level3_rewards);
                var level4_rewards = $('#level4_rewards').maskMoney('unmasked')[0];
                $('#level4_rewards').val(level4_rewards);

                var promo_umroh = $('#promo_umroh').maskMoney('unmasked')[0];
                $('#promo_umroh').val(promo_umroh);
            });

            $('#rewards-hajj-setting-form').submit(function () {
                var referal11_rewards = $('#referal11_rewards').maskMoney('unmasked')[0];
                $('#referal11_rewards').val(referal11_rewards);
                var promo_haji = $('#promo_haji').maskMoney('unmasked')[0];
                $('#promo_haji').val(promo_haji);
                // var referal33_rewards = $('#referal33_rewards').maskMoney('unmasked')[0];
                // $('#referal33_rewards').val(referal33_rewards);
                // var referal44_rewards = $('#referal44_rewards').maskMoney('unmasked')[0];
                // $('#referal44_rewards').val(referal44_rewards);

                var level11_rewards = $('#level11_rewards').maskMoney('unmasked')[0];
                $('#level11_rewards').val(level11_rewards);
                var level22_rewards = $('#level22_rewards').maskMoney('unmasked')[0];
                $('#level22_rewards').val(level22_rewards);
                var level33_rewards = $('#level33_rewards').maskMoney('unmasked')[0];
                $('#level33_rewards').val(level33_rewards);
                var level44_rewards = $('#level44_rewards').maskMoney('unmasked')[0];
                $('#level44_rewards').val(level44_rewards);
            });

        });
    </script>
@endpush
