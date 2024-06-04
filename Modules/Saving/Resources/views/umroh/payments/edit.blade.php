@extends('layouts.app')

@if ($savingPayment->trx_type == 'Saving')
    @section('title', 'Edit Umroh Savings Payment')

    @section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-savings.index') }}">Umroh Savings</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-saving-payments.index', $savingPayment->saving_id) }}">{{ $umroh_saving->reference }}</a></li>

        <li class="breadcrumb-item active">Edit Umroh Savings Payment</li>
    </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <form id="payment-form" action="{{ route('umroh-saving-payments.update', $savingPayment) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-12">
                        @include('utils.alerts')
                        <div class="form-group">
                            <button class="btn btn-primary">Update Savings Payment <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="reference">Reference ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="reference" required readonly value="{{ $savingPayment->reference }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="date">Savings Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ $savingPayment->getAttributes()['date'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_saving">Savings Balance <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_saving" required value="{{ format_currency($umroh_saving->total_saving) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="amount">Savings Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="amount" type="text" class="form-control" name="amount" required value="{{ old('amount') ?? $savingPayment->amount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="from-group">
                                            <div class="form-group">
                                                <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                                <select class="form-control" name="payment_method" id="payment_method" required>
                                                    <option {{ $savingPayment->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                                    <option {{ $savingPayment->payment_method == 'Transfer' ? 'selected' : '' }} value="Transfer">Transfer</option>
                                                    <option {{ $savingPayment->payment_method == 'QRIS' ? 'selected' : '' }} value="QRIS">QRIS</option>
                                                    <option {{ $savingPayment->payment_method == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Payment Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected>None</option>
                                                <option {{ $savingPayment->status == 'Approval' ? 'selected' : '' }} value="Approval">Approval</option>
                                                <option {{ $savingPayment->status == 'Verified' ? 'selected' : '' }} value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" rows="4" name="note">{{ old('note') ?? $savingPayment->note }}</textarea>
                                </div>

                                <input type="hidden" value="{{ $umroh_saving->id }}" name="saving_id">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="savings">Savings Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                        <div class="dz-message" data-dz-message>
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    @endsection

    @section('third_party_scripts')
        <script src="{{ asset('js/dropzone.js') }}"></script>
    @endsection

    @push('page_scripts')
        <script>
            var uploadedDocumentMap = {}
            Dropzone.options.documentDropzone = {
                url: '{{ route('dropzone.upload') }}',
                maxFilesize: 1,
                acceptedFiles: '.jpg, .jpeg, .png',
                maxFiles: 2,
                addRemoveLinks: true,
                dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                    uploadedDocumentMap[file.name] = response.name;
                },
                removedfile: function (file) {
                    file.previewElement.remove();
                    var name = '';
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name;
                    } else {
                        name = uploadedDocumentMap[file.name];
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove();
                },
                init: function () {
                    @if(isset($savingPayment) && $savingPayment->getMedia('savings'))
                    var files = {!! json_encode($savingPayment->getMedia('savings')) !!};
                    for (var i in files) {
                        var file = files[i];
                        this.options.addedfile.call(this, file);
                        this.options.thumbnail.call(this, file, file.original_url);
                        file.previewElement.classList.add('dz-complete');
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                    }
                    @endif
                }
            }
        </script>

        <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#amount').maskMoney({
                    prefix:'{{ settings()->currency->symbol }}',
                    thousands:'{{ settings()->currency->thousand_separator }}',
                    decimal:'{{ settings()->currency->decimal_separator }}',
                });

                $('#amount').maskMoney('mask');

                // $('#getTotalAmount').click(function () {
                //     $('#amount').maskMoney('mask', {{ $umroh_saving->total_saving }});
                // });

                $('#payment-form').submit(function () {
                    var amount = $('#amount').maskMoney('unmasked')[0];
                    $('#amount').val(amount);
                });
            });
        </script>
    @endpush
@else
    @section('title', 'Edit Umroh Savings Refund')

    @section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-savings.index') }}">Umroh Savings</a></li>
        {{-- <li class="breadcrumb-item"><a href="{{ route('umroh-savings.show', $umroh_saving) }}">{{ $umroh_saving->reference }}</a></li> --}}
        <li class="breadcrumb-item"><a href="{{ route('umroh-saving-payments.index', $savingPayment->saving_id) }}">{{ $umroh_saving->reference }}</a></li>

        <li class="breadcrumb-item active">Edit Umroh Savings Refund</li>
    </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <form id="payment-form" action="{{ route('umroh-saving-payments.update', $savingPayment) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-12">
                        @include('utils.alerts')
                        <div class="form-group">
                            <button class="btn btn-primary">Update Savings Refund <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="reference">Reference ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="reference" required readonly value="{{ $savingPayment->reference }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="date">Refund Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ $savingPayment->getAttributes()['date'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_saving">Savings Balance <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_saving" required value="{{ format_currency($umroh_saving->total_saving) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="refund_amount">Refund Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="refund_amount" type="text" class="form-control" name="refund_amount" required value="{{ old('refund_amount') ?? $savingPayment->refund_amount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="from-group">
                                            <div class="form-group">
                                                <label for="payment_method">Refund Method <span class="text-danger">*</span></label>
                                                <select class="form-control" name="payment_method" id="payment_method" required>
                                                    <option {{ $savingPayment->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                                    <option {{ $savingPayment->payment_method == 'Transfer' ? 'selected' : '' }} value="Transfer">Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Refund Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected>None</option>
                                                <option {{ $savingPayment->status == 'Approval' ? 'selected' : '' }} value="Approval">Approval</option>
                                                <option {{ $savingPayment->status == 'Verified' ? 'selected' : '' }} value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" rows="4" name="note">{{ old('note') ?? $savingPayment->note }}</textarea>
                                </div>

                                <input type="hidden" value="{{ $umroh_saving->id }}" name="saving_id">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="savings">Refund Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                        <div class="dz-message" data-dz-message>
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    @endsection

    @section('third_party_scripts')
        <script src="{{ asset('js/dropzone.js') }}"></script>
    @endsection

    @push('page_scripts')
        <script>
            var uploadedDocumentMap = {}
            Dropzone.options.documentDropzone = {
                url: '{{ route('dropzone.upload') }}',
                maxFilesize: 1,
                acceptedFiles: '.jpg, .jpeg, .png',
                maxFiles: 2,
                addRemoveLinks: true,
                dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                    uploadedDocumentMap[file.name] = response.name;
                },
                removedfile: function (file) {
                    file.previewElement.remove();
                    var name = '';
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name;
                    } else {
                        name = uploadedDocumentMap[file.name];
                    }
                    $('form').find('input[name="document[]"][value="' + name + '"]').remove();
                },
                init: function () {
                    @if(isset($savingPayment) && $savingPayment->getMedia('savings'))
                    var files = {!! json_encode($savingPayment->getMedia('savings')) !!};
                    for (var i in files) {
                        var file = files[i];
                        this.options.addedfile.call(this, file);
                        this.options.thumbnail.call(this, file, file.original_url);
                        file.previewElement.classList.add('dz-complete');
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                    }
                    @endif
                }
            }
        </script>

        <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#refund_amount').maskMoney({
                    prefix:'{{ settings()->currency->symbol }}',
                    thousands:'{{ settings()->currency->thousand_separator }}',
                    decimal:'{{ settings()->currency->decimal_separator }}',
                });

                $('#refund_amount').maskMoney('mask');

                // $('#getTotalAmount').click(function () {
                //     $('#amount').maskMoney('mask', {{ $umroh_saving->total_saving }});
                // });

                $('#payment-form').submit(function () {
                    var refund_amount = $('#refund_amount').maskMoney('unmasked')[0];
                    $('#refund_amount').val(refund_amount);
                });
            });
        </script>
    @endpush
@endif


