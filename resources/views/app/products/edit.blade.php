<x-app-layout title="Editar Produto">
    <x-header title="Editar Produto">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Editar Produto</span>
        </div>
        <div class="card-body">
            @livewire('product.product-create-edit', ['product' => $product])
        </div>
    </div>
</x-app-layout>
