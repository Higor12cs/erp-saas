<x-app-layout title="Pedidos">
    <x-header title="Pedidos">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Novo Pedido</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Pedidos</span>
        </div>
        <div class="card-body">
            @livewire('order.order-table')
        </div>
    </div>
</x-app-layout>
