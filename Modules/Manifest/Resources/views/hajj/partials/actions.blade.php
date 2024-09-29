<div class="btn-group dropleft">
    <button type="button" class="btn btn-ghost-primary dropdown rounded" data-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @can('access_purchase_payments') --}}
            {{-- <a href="{{ route('umroh-manifest-payments.index', $data->id) }}" class="dropdown-item">
                <i class="bi bi-cash-coin mr-2 text-warning" style="line-height: 1;"></i> Show Payments
            </a> --}}
        {{-- @endcan --}}
        {{-- @can('access_purchase_payments') --}}
            {{-- @if($data->due_amount > 0) --}}
                {{-- <a href="{{ route('umroh-manifest-payments.create', $data->id) }}" class="dropdown-item">
                    <i class="bi bi-plus-circle-dotted mr-2 text-success" style="line-height: 1;"></i> Add Payment
                </a> --}}
            {{-- @endif --}}
        {{-- @endcan
        @can('edit_purchases') --}}
            <a href="{{ route('hajj-manifests.edit', $data->id) }}" class="dropdown-item">
                <i class="bi bi-pencil mr-2 text-primary" style="line-height: 1;"></i> Edit
            </a>
        {{-- @endcan
        @can('edit_purchases') --}}
            <a href="{{ route('hajj-manage-manifests.manage', $data->id) }}" class="dropdown-item">
                <i class="bi bi-pencil-square mr-2 text-warning" style="line-height: 1;"></i> Manage
            </a>
        {{-- @endcan
        @can('show_purchases') --}}
            <a href="{{ route('hajj-manifests.show', $data->id) }}" class="dropdown-item">
                <i class="bi bi-eye mr-2 text-info" style="line-height: 1;"></i> Details
            </a>
        {{-- @endcan
        @can('delete_purchases') --}}
            {{-- <button id="delete" class="dropdown-item" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }">
                <i class="bi bi-trash mr-2 text-danger" style="line-height: 1;"></i> Delete
                <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('hajj-manifests.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </button> --}}

            <button id="delete" class="dropdown-item" onclick="
            // event.preventDefault();
            // if (confirm('Are you sure? It will delete the data permanently!')) {
            // document.getElementById('destroy{{ $data->id }}').submit()
            // }">
            <i class="bi bi-trash mr-2 text-secondary" style="line-height: 1;"></i> Delete
            {{-- <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('hajj-manifests.destroy', $data->id) }}" method="POST">
                @csrf
                @method('delete')
            </form> --}}
            </button>

        {{-- @endcan --}}
    </div>
</div>
