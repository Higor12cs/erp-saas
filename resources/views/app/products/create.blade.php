<x-app-layout title="Novo Produto">
    <x-header title="Novo Produto">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Novo Produto</span>
        </div>
        <div class="card-body">
            @livewire('product.product-create-edit')
        </div>
    </div>
</x-app-layout>
