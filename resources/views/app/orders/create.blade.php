<x-app-layout title="Novo Pedido">
    <x-header title="Novo Pedido">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Novo Pedido</span>
        </div>
        <div class="card-body">
            @livewire('order.order-create-edit')
        </div>
    </div>
</x-app-layout>
