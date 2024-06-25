@extends('layouts.app')

@section('title', 'Details Agent Rewards Payment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Agents Rewards</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agent-payments.index', $agentPayment->agent_id) }}">{{ $agent->agent_code }}</a></li>
        <li class="breadcrumb-item active">Details Agent Rewards Payment Receipt</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            ID Register : <strong>{{ $agentPayment->reference }}</strong>
                        </div>
                        <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('agent-payments.pdf', $agentPayment->id) }}">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('agent-payments.pdf', $agentPayment->id) }}">
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Category : <strong>Agent Rewards Payment Receipt</strong>
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
                                <h5 class="mb-2 border-bottom pb-2">Agent Info:</h5>
                                <div><strong>{{ $agent->agent_name }}</strong></div>
                                <div>{{ $agent->address }}</div>
                                <div>Phone: {{ $agent->agent_phone }}</div>
                                <div>Email: {{ $agent->agent_email }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                {{-- <h5 class="mb-2 border-bottom pb-2">Agent Info:</h5>
                                <div><strong>{{ $customer->customer_name }}</strong></div>
                                <div>{{ $customer->address }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                                <div>Email: {{ $customer->customer_email }}</div> --}}
                            </div>
                        </div>

                        <div class="table-responsive-sm mb-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="align-middle">ID Reference</th>
                                        <th class="align-middle">Payment Date</th>
                                        <th class="align-middle">Agent Name</th>
                                        <th class="align-middle">Phone Number</th>
                                        <th class="align-middle">Category</th>
                                        <th class="align-middle">Rewards Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $agentPayment->reference }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ date('d-m-Y', strtotime($agentPayment->date)) }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $agent->agent_name }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ $agent->agent_phone }}
                                        </td>
                                        <td class="align-middle">
                                            @if ($agentPayment->trx_type == 'Payment')
                                                <span class="badge badge-success" style="font-size: 16px;">
                                                    {{ $agentPayment->trx_type }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger" style="font-size: 16px;">
                                                    {{ $agentPayment->trx_type }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle" style="font-size: 16px;">
                                            {{ format_currency($agent->total_reward-$agent->paid_reward) }}
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <table class="table table-striped col-lg-6">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Payment Method</th>
                                        <th class="align-middle">Payment Amount</th>
                                        <th class="align-middle">Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                            {{ $agentPayment->payment_method }}
                                        </td>
                                        <td class="align-middle" style="font-size: 16px; font-weight: bold;">
                                            {{ format_currency($agentPayment->amount) }}
                                        </td>
                                        <td class="align-middle">
                                            @if ($agentPayment->status == 'Verified')
                                                <span class="badge badge-success" style="font-size: 16px;">
                                                    {{ $agentPayment->status }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger" style="font-size: 16px;">
                                                    {{ $agentPayment->status }}
                                                </span>
                                            @endif
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
                                            <td class="left"><strong>PT {{ settings()->company_name }}</strong></td>
                                            {{-- <td class="right">{{ format_currency($purchase->discount_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->tax_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0">
                                                <img width="180" src="{{ asset('images/sign.png') }}" alt="Sign">
                                            </td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"></td>
                                            {{-- <td class="right">{{ format_currency($purchase->shipping_amount) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td class="left border-0"><strong>{{ settings()->sign_name }}</strong></td>
                                            {{-- <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td> --}}
                                        </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <label for="rewards">Payment Receipt <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 2, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    @forelse($agentPayment->getMedia('rewards') as $media)
                                        <img src="{{ $media->getUrl() }}" alt="Payment Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                    @empty
                                        <img src="{{ $agentPayment->getFirstMediaUrl('rewards') }}" alt="Payment Receipt" class="img-fluid img-thumbnail mb-2" style="width:300px;height:350px;">
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
