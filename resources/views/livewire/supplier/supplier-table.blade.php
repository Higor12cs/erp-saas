<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="col-5">Nome</th>
                <th class="col-6">Sobrenome</th>
                <th class="col-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->first_name }}</td>
                    <td>{{ $supplier->last_name }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-primary">Editar</a>
                        <button wire:click="delete('{{ $supplier->id }}')"
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

    {{ $this->suppliers->links() }}
</div>
