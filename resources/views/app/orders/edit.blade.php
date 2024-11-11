<x-app-layout title="Editar Pedido">
    <x-header title="Editar Pedido">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Editar Pedido</span>
        </div>
        <div class="card-body">
            @dump($order)
            <!-- @livewire('order.order-item', ['order' => $order]) -->
        </div>
    </div>
</x-app-layout>
