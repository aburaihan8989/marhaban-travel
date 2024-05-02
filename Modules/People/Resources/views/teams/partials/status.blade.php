@if ($data->team_status == 'Active')
    <span class="badge badge-success" style="font-size: 13px;">
        {{ $data->team_status }}
    </span>
@elseif ($data->team_status == 'Disable')
    <span class="badge badge-secondary" style="font-size: 13px;">
        {{ $data->team_status }}
    </span>
@else
@endif
