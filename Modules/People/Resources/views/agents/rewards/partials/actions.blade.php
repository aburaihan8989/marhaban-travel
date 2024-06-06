<div class="btn-group dropleft">
    <button type="button" class="btn btn-ghost-primary dropdown rounded" data-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <div class="dropdown-menu">
        {{-- @can('access_purchase_payments') --}}
            <a href="#" class="dropdown-item">
                <i class="bi bi-cash-coin mr-2 text-warning" style="line-height: 1;"></i> Show Payments
            </a>
        {{-- @endcan --}}
        {{-- @can('access_purchase_payments') --}}
            <a href="#" class="dropdown-item">
                <i class="bi bi-plus-circle-dotted mr-2 text-success" style="line-height: 1;"></i> Add Payment
            </a>
        {{-- @endcan --}}
        {{-- @can('show_purchases') --}}
            <a href="#" class="dropdown-item">
                <i class="bi bi-eye mr-2 text-info" style="line-height: 1;"></i> Details
            </a>
        {{-- @endcan --}}
        {{-- @can('access_purchase_payments') --}}
            <a href="{{ route('rewards-agents-list.show-agents', $data->id) }}" class="dropdown-item">
                <i class="bi bi-people-fill mr-2 text-primary" style="line-height: 1;"></i> Show Agents
            </a>
        {{-- @endcan --}}
        {{-- @can('access_purchase_payments') --}}
            <a href="#" class="dropdown-item">
                <i class="bi bi-people-fill mr-2 text-primary" style="line-height: 1;"></i> Show Customers
            </a>
        {{-- @endcan --}}

    </div>
</div>