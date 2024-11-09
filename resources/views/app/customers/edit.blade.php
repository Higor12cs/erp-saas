<x-app-layout title="Editar Cliente">
    <x-header title="Editar Cliente">
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Editar Cliente</span>
        </div>
        <div class="card-body">
            @livewire('customer.customer-create-edit', ['customer' => $customer])
        </div>
    </div>
</x-app-layout>
