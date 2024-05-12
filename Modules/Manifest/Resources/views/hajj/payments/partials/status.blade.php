@if ($data->status == 'Verified')
    <span class="badge badge-success" style="font-size: 13px;">
        {{ $data->status }}
    </span>
@else
    <span class="badge badge-danger" style="font-size: 13px;">
        {{ $data->status }}
    </span>
@endif
