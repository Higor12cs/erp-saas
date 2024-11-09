<x-app-layout title="Clientes">
    <x-header title="Clientes">
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Novo Cliente</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Clientes</span>
        </div>
        <div class="card-body">
            @livewire('customer.customer-table')
        </div>
    </div>
</x-app-layout>
