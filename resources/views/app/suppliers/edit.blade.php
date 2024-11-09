<x-app-layout title="Editar Fornecedor">
    <x-header title="Editar Fornecedor">
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Editar Fornecedor</span>
        </div>
        <div class="card-body">
            @livewire('supplier.supplier-create-edit', ['supplier' => $supplier])
        </div>
    </div>
</x-app-layout>
