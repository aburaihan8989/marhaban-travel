{{-- @can('access_sale_payments') --}}
    <a href="{{ route('agent-payments.edit', [$data->agents->id, $data->id]) }}" class="btn btn-info btn-sm">
        <i class="bi bi-pencil"></i>
    </a>
{{-- @endcan
{{-- @can('access_sale_payments') --}}
@if ($data->status == 'Verified')
    <a href="{{ route('agent-payments.view', [$data->agents->id, $data->id]) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-eye"></i>
    </a>
@else
    <a href="#" class="btn btn-secondary btn-sm">
        <i class="bi bi-eye"></i>
    </a>
@endif
{{-- @endcan
@can('access_sale_payments') --}}
    <button id="delete" class="btn btn-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        <i class="bi bi-trash"></i>
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('agent-payments.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
{{-- @endcan --}}
