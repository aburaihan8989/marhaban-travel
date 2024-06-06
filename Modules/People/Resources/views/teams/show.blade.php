@extends('layouts.app')

@section('title', 'Team Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Teams</a></li>
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
                                    <th>NIK Team</th>
                                    <td>{{ $team->nik_number }}</td>
                                </tr>
                                <tr>
                                    <th>Team Name</th>
                                    <td>{{ $team->team_name }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ date('d-m-Y', strtotime($team->date_birth)) }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $team->team_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $team->team_email }}</td>
                                </tr>
                                <tr>
                                    <th>Team Status</th>
                                    <td>{{ $team->team_status }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        @if($team->gender == 'L')
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $team->division }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $team->city }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $team->country }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $team->address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="teams">Photo Team <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 1, Max File Size: 1MB, Image Size: 400x400"></i></label>
                        <br>
                        @forelse($team->getMedia('teams') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Photo Team" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $team->getFirstMediaUrl('teams') }}" alt="Photo Team" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

