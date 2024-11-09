<x-app-layout title="Produtos">
    <x-header title="Produtos">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Novo Produto</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Produtos</span>
        </div>
        <div class="card-body">
            @livewire('product.product-table')
        </div>
    </div>
</x-app-layout>
