@if ($data->status == 'Active')
    <span class="badge badge-success" style="font-size: 13px;">
        {{ $data->status }}
    </span>
@elseif ($data->status == 'Flight')
    <span class="badge badge-danger" style="font-size: 13px;">
        {{ $data->status }}
    </span>
@else
    <span class="badge badge-secondary" style="font-size: 13px;">
        {{ $data->status }}
    </span>
@endif
