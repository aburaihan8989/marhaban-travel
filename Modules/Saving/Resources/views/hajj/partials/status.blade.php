@if ($data->status == 'Active')
    <span class="badge badge-success">
        {{ $data->status }}
    </span>
@elseif ($data->status == 'Cancel')
    <span class="badge badge-secondary">
        {{ $data->status }}
    </span>
@else
    <span class="badge badge-primary">
        {{ $data->status }}
    </span>
@endif
