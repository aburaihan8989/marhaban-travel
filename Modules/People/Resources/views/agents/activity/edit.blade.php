@extends('layouts.app')

@section('title', 'Edit Activity Report')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('activity-agent.data') }}">Data Agents Activity</a></li>
        <li class="breadcrumb-item active">Edit Activity Report</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form id="activity-form" action="{{ route('activity-agent.update', $activity['id']) }}" method="POST">
            @csrf
            @method('post')
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Update Report <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">ID Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required value="{{ $activity['reference'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="agent_name">Agent Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $activity['agent_code'] . ' | ' . $activity['agent_name'] }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="date_activity">Activity Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_activity" required value="{{ $activity['date_activity'] }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="detail_activity">Activity Details</label>
                                <textarea class="form-control" rows="6" name="detail_activity">{{ $activity['detail_activity'] }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endpush
