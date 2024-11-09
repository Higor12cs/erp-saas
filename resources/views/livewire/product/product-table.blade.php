<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="col-8">Nome</th>
                <th class="col-3">Preço</th>
                <th class="col-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price,2,',','.') }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">Editar</a>
                    <button wire:click="delete('{{ $product->id }}')"
                        wire:confirm="Tem certeza que deseja excluir este registro?"
                        class="btn btn-sm btn-danger">Excluir</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Nenhum registro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $this->products->links() }}
</div>