<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="col-9">Cliente</th>
                <th class="col-1">Data</th>
                <th class="col-1">Valor</th>
                <th class="col-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->orders as $order)
            <tr>
                <td>{{ $order->customer->first_name }}</td>
                <td>{{ $order->issue_date->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total_price, 2, ',', '.') }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-primary">Editar</a>
                    <button wire:click="delete('{{ $order->id }}')"
                        wire:confirm="Tem certeza que deseja excluir este registro?"
                        class="btn btn-sm btn-danger">Excluir</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Nenhum registro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $this->orders->links() }}
</div>