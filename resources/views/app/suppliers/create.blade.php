<x-app-layout title="Novo Fornecedor">
    <x-header title="Novo Fornecedor">
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Novo Fornecedor</span>
        </div>
        <div class="card-body">
            @livewire('supplier.supplier-create-edit')
        </div>
    </div>
</x-app-layout>
