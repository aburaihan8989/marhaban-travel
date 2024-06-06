@if ($data->agent_status == 'Active')
    <span class="badge badge-success" style="font-size: 13px;">
        {{ $data->agent_status }}
    </span>
@elseif ($data->agent_status == 'Closed')
    <span class="badge badge-secondary" style="font-size: 13px;">
        {{ $data->agent_status }}
    </span>
@else
@endif
