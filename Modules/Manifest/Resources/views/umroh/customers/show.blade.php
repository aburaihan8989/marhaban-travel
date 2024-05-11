@extends('layouts.app')

@section('title', 'Customer Manifest Umroh Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-manage-manifests.manage', $umroh_manifest_customer_id->manifest_id) }}">Umroh Manifest Manages</a></li>
        <li class="breadcrumb-item active">Customer Manifest Umroh Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Register ID : <strong>{{ $umroh_manifest_customer_id->reference }}</strong>
                        </div>
                        <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('umroh-manifest-customers.pdf', $umroh_manifest_customer_id->id) }}">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('umroh-manifest-customers.pdf', $umroh_manifest_customer_id->id) }}">
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Category : <strong>Umroh Manifest Customer Details</strong>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Travel Info:</h5>
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                                <div>Phone: {{ settings()->company_phone }}</div>
                                <div>Email: {{ settings()->company_email }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Customer Info:</h5>
                                <div><strong>{{ $customer->customer_name }}</strong></div>
                                <div>{{ $customer->address }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                                <div>Email: {{ $customer->customer_email }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Agent Info:</h5>
                                {{-- <div><strong>{{ $customer->customer_name }}</strong></div>
                                <div>{{ $customer->address }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                                <div>Email: {{ $customer->customer_email }}</div> --}}
                            </div>

                            {{-- <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                                <div>Invoice: <strong>INV/{{ $purchase->reference }}</strong></div>
                                <div>Date: {{ \Carbon\Carbon::parse($purchase->date)->format('d M, Y') }}</div>
                                <div>
                                    Status: <strong>{{ $purchase->status }}</strong>
                                </div>
                                <div>
                                    Payment Status: <strong>{{ $purchase->payment_status }}</strong>
                                </div>
                            </div> --}}

                        </div>

                        <div class="table-responsive-sm mb-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Reference</th>
                                        <th class="align-middle">Register Date</th>
                                        <th class="align-middle">Customer Name</th>
                                        <th class="align-middle">Phone Number</th>
                                        <th class="align-middle">Package Price</th>
                                        <th class="align-middle">Total Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            {{ $umroh_manifest_customer_id->reference }}
                                        </td>
                                        <td class="align-middle">
                                            {{ date('d-m-Y', strtotime($umroh_manifest_customer_id->register_date)) }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $umroh_manifest_customer_id->customer_name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $umroh_manifest_customer_id->customer_phone }}
                                        </td>
                                        <td class="align-middle">
                                            {{ format_currency($umroh_manifest_customer_id->total_price) }}
                                        </td>
                                        <td class="align-middle">
                                            {{ format_currency($umroh_manifest_customer_id->total_payment) }}
                                        </td>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Remaining Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            {{-- <span class="badge badge-success" style="font-size: 13px;">
                                                {{ $umroh_manifest->status }}
                                            </span> --}}
                                            @if ($umroh_manifest_customer_id->status == 'Completed')
                                                <span class="badge badge-success" style="font-size: 13px;">
                                                    {{ $umroh_manifest_customer_id->status }}
                                                </span>
                                            @else
                                                <span class="badge badge-warning" style="font-size: 13px;">
                                                    {{ $umroh_manifest_customer_id->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                            {{ format_currency($umroh_manifest_customer_id->remaining_payment) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-5 ml-md-auto">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="left"><strong>PT Marhaban Makkah Madinah</strong></td>
                                        {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0"></td>
                                        {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                    </tr>
                                    <tr>
                                        <td class="left border-0"><strong>Direktur Utama</strong></td>
                                        {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <hr>

                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Ticket Status</legend>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->ticket == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Completed</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Not Yet</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Visa Status</legend>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->visa == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Completed</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Not Yet</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Perlengkapan</legend>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->big_suitcase == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Big Suitcase</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Big Suitcase</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->small_suitcase == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Suitcase</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Suitcase</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->small_bag == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Bag</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Bag</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->clothes == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Clothes</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Clothes</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0"></legend>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->small_pillow == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Pillow</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Small Pillow</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-check">
                                    @if ($umroh_manifest_customer_id->scarf == '1')
                                        <i class="form-check-input bi bi-check-circle-fill" style="line-height:1;font-size:25px;color:green;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Scarf</label>
                                    @else
                                        <i class="form-check-input bi bi-x-circle-fill" style="line-height:1;font-size:25px;color:red;position:absolute;top:-5px;"></i>
                                        <label class="form-check-label ml-3" for="ticket">Scarf</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <label for="photo">Photo Customer <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                        @forelse($umroh_manifest_customer_id->umrohCustomers->getMedia('photos') as $media)
                                            <img src="{{ $media->getUrl() }}" alt="Photo Customer" class="img-fluid img-thumbnail mb-2">
                                        @empty
                                            <img src="{{ $umroh_manifest_customer_id->umrohCustomers->getFirstMediaUrl('photos') }}" alt="Photo Customer" class="img-fluid img-thumbnail mb-2">
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-0">
                                                <tr>
                                                    <th>NIK Customer</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->nik_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->customer_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date of Birth</th>
                                                    <td>{{ date('d-m-Y', strtotime($umroh_manifest_customer_id->umrohCustomers->date_birth)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td>
                                                        @if($umroh_manifest_customer_id->umrohCustomers->gender == 'L')
                                                            Male
                                                        @else
                                                            Female
                                                        @endif
                                                        {{-- {{ $umroh_manifest_customer_id->umrohCustomers->gender }} --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Age Group</th>
                                                    <td>
                                                        @if($umroh_manifest_customer_id->umrohCustomers->age_group == 'A')
                                                            Adult
                                                        @elseif($umroh_manifest_customer_id->umrohCustomers->age_group == 'K')
                                                            Kids
                                                        @else
                                                            Infant
                                                        @endif
                                                        {{-- {{ $umroh_manifest_customer_id->umrohCustomers->age_group }} --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Paspor Number</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->paspor_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Paspor Active</th>
                                                    <td>{{ date('d-m-Y', strtotime($umroh_manifest_customer_id->umrohCustomers->paspor_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone Number</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->customer_phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->customer_email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status Member</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->customer_status }}</td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->city }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $umroh_manifest_customer_id->umrohCustomers->address }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

