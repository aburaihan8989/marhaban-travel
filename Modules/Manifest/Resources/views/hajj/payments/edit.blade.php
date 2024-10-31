@extends('layouts.app')

@if ($hajjManifestPayment->trx_type == 'Payment')
    @section('title', 'Edit Customer Payment Hajj')

    @section('breadcrumb')
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-manage-manifests.manage', $hajj_manifest->manifest_id) }}">Manage Hajj Manifest</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-manifest-payments.index', $hajjManifestPayment->hajj_manifest_customer_id) }}">{{ $hajj_manifest->reference }}</a></li>
            <li class="breadcrumb-item active">Edit Customer Payment Hajj</li>
        </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <form id="hajj-payment-form" action="{{ route('hajj-manifest-payments.update', $hajjManifestPayment) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-12">
                        @include('utils.alerts')
                        <div class="form-group">
                            <button class="btn btn-primary">Update Hajj Payment <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="reference">ID Transaction <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="reference" required readonly value="{{ $hajjManifestPayment->reference }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Payment Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected>None</option>
                                                <option {{ $hajjManifestPayment->status == 'Approval' ? 'selected' : '' }} value="Approval">Approval</option>
                                                <option {{ $hajjManifestPayment->status == 'Verified' ? 'selected' : '' }} value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_price" required value="{{ format_currency($hajj_manifest->total_price) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_payment">Total Payment <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_payment" required value="{{ format_currency($hajj_manifest->total_payment) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="remaining_payment">Remaining Payment <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="remaining_payment" required value="{{ format_currency($hajj_manifest->remaining_payment) }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="amount">Payment Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="amount" type="text" class="form-control" name="amount" required value="{{ old('amount') ?? $hajjManifestPayment->amount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="from-group">
                                            <div class="form-group">
                                                <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                                <select class="form-control" name="payment_method" id="payment_method" required>
                                                    <option {{ $hajjManifestPayment->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                                    <option {{ $hajjManifestPayment->payment_method == 'Transfer' ? 'selected' : '' }} value="Transfer">Transfer</option>
                                                    <option {{ $hajjManifestPayment->payment_method == 'QRIS' ? 'selected' : '' }} value="QRIS">QRIS</option>
                                                    <option {{ $hajjManifestPayment->payment_method == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="date">Payment Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ $hajjManifestPayment->getAttributes()['date'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="payment_reference">Transaction Reference <span class="text-danger"></span></label>
                                            <div class="input-group">
                                                <input id="payment_reference" type="text" class="form-control" name="payment_reference" value="{{ $umroh_manifest->payment_reference }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" rows="4" name="note">{{ old('note') ?? $hajjManifestPayment->note }}</textarea>
                                </div>

                                <input type="hidden" value="{{ $hajj_manifest->id }}" name="hajj_manifest_customer_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="payments">Payment Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
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
                    @if(isset($hajjManifestPayment) && $hajjManifestPayment->getMedia('payments'))
                    var files = {!! json_encode($hajjManifestPayment->getMedia('payments')) !!};
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

                $('#hajj-payment-form').submit(function () {
                    var amount = $('#amount').maskMoney('unmasked')[0];
                    $('#amount').val(amount);
                });
            });
        </script>
    @endpush
@else
    @section('title', 'Edit Customer Refund Payment Hajj')

    @section('breadcrumb')
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-manage-manifests.manage', $hajj_manifest->manifest_id) }}">Manage Hajj Manifest</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hajj-manifest-payments.index', $hajjManifestPayment->hajj_manifest_customer_id) }}">{{ $hajj_manifest->reference }}</a></li>
            <li class="breadcrumb-item active">Edit Customer Refund Payment Hajj</li>
        </ol>
    @endsection

    @section('content')
        <div class="container-fluid">
            <form id="hajj-payment-form" action="{{ route('hajj-manifest-payments.update', $hajjManifestPayment) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-12">
                        @include('utils.alerts')
                        <div class="form-group">
                            <button class="btn btn-primary">Update Refund Payment <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="reference">ID Transaction <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="reference" required readonly value="{{ $hajjManifestPayment->reference }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Refund Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" selected>None</option>
                                                <option {{ $hajjManifestPayment->status == 'Approval' ? 'selected' : '' }} value="Approval">Approval</option>
                                                <option {{ $hajjManifestPayment->status == 'Verified' ? 'selected' : '' }} value="Verified">Verified</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_price" required value="{{ format_currency($hajj_manifest->total_price) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="total_payment">Total Payment <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="total_payment" required value="{{ format_currency($hajj_manifest->total_payment) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="remaining_payment">Remaining Payment <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="remaining_payment" required value="{{ format_currency($hajj_manifest->remaining_payment) }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="refund_amount">Refund Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="refund_amount" type="text" class="form-control" name="refund_amount" required value="{{ old('refund_amount') ?? $hajjManifestPayment->refund_amount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="from-group">
                                            <div class="form-group">
                                                <label for="payment_method">Refund Method <span class="text-danger">*</span></label>
                                                <select class="form-control" name="payment_method" id="payment_method" required>
                                                    <option {{ $hajjManifestPayment->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                                    <option {{ $hajjManifestPayment->payment_method == 'Transfer' ? 'selected' : '' }} value="Transfer">Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="date">Refund Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ $hajjManifestPayment->getAttributes()['date'] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" rows="4" name="note">{{ old('note') ?? $hajjManifestPayment->note }}</textarea>
                                </div>

                                <input type="hidden" value="{{ $hajj_manifest->id }}" name="hajj_manifest_customer_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="payments">Refund Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
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
                    @if(isset($hajjManifestPayment) && $hajjManifestPayment->getMedia('payments'))
                    var files = {!! json_encode($hajjManifestPayment->getMedia('payments')) !!};
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

                $('#hajj-payment-form').submit(function () {
                    var refund_amount = $('#refund_amount').maskMoney('unmasked')[0];
                    $('#refund_amount').val(refund_amount);
                });
            });
        </script>
    @endpush
@endif

