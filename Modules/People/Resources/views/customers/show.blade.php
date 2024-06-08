@extends('layouts.app')

@section('title', 'Customer Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <tr>
                                    <th>NIK Customer</th>
                                    <td>{{ $customer->nik_number }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $customer->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ date('d-m-Y', strtotime($customer->date_birth)) }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $customer->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Paspor Number</th>
                                    <td>{{ $customer->paspor_number }}</td>
                                </tr>
                                <tr>
                                    <th>Paspor Active</th>
                                    <td>{{ date('d-m-Y', strtotime($customer->paspor_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Email</th>
                                    <td>{{ $customer->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Status Member</th>
                                    <td>{{ $customer->customer_status }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        @if($customer->gender == 'L')
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Age Group</th>
                                    <td>
                                        @if($customer->age_group == 'A')
                                            Adult
                                        @elseif($customer->age_group == 'K')
                                            Kids
                                        @else
                                            Infant
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $customer->city }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $customer->country }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $customer->address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="photo">Photo Customer <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        <br>
                        @forelse($customer->getMedia('photos') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Photo Customer" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $customer->getFirstMediaUrl('photos') }}" alt="Photo Customer" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

