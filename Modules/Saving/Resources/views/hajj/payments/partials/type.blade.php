@if ($data->trx_type == 'Saving')
    <span class="badge badge-success" style="font-size: 13px;">
        {{ $data->trx_type }}
    </span>
@else
    <span class="badge badge-danger" style="font-size: 13px;">
        {{ $data->trx_type }}
    </span>
@endif
