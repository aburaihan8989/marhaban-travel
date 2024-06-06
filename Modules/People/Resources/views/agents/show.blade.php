@extends('layouts.app')

@section('title', 'Details Agent')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
        <li class="breadcrumb-item active">Details Agent</li>
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
                                    <th>Agent Code</th>
                                    <td>{{ $agent->agent_code }}</td>
                                </tr>
                                <tr>
                                    <th>NIK Agent</th>
                                    <td>{{ $agent->nik_number }}</td>
                                </tr>
                                <tr>
                                    <th>Agent Name</th>
                                    <td>{{ $agent->agent_name }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ date('d-m-Y', strtotime($agent->date_birth)) }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $agent->agent_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $agent->agent_email }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        @if($agent->gender == 'L')
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Level Agent</th>
                                    <td>{{ $agent->level_agent }}</td>
                                </tr>
                                <tr>
                                    <th>Agent Status</th>
                                    <td>{{ $agent->agent_status }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $agent->city }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $agent->country }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $agent->address }}</td>
                                </tr>
                                <tr>
                                    <th>Referal Name</th>
                                    <td>{{ $referal_agent->agent_code . ' | ' . $referal_agent->agent_name }}</td>
                                </tr>
                                <tr>
                                    <th>Referal Level</th>
                                    <td>{{ $referal_agent->level_agent }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-75">
                    <div class="card-body">
                        <label for="agents">Photo Agent <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        <br>
                        @forelse($agent->getMedia('agents') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Photo Agent" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $agent->getFirstMediaUrl('agents') }}" alt="Photo Agent" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

