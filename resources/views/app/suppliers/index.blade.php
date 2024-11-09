<x-app-layout title="Fornecedores">
    <x-header title="Fornecedores">
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Novo Fornecedor</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Fornecedores</span>
        </div>
        <div class="card-body">
            @livewire('supplier.supplier-table')
        </div>
    </div>
</x-app-layout>
