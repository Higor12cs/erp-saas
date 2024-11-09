<x-app-layout title="Novo Cliente">
    <x-header title="Novo Cliente">
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Voltar</a>
    </x-header>

    <div class="card">
        <div class="card-header">
            <span>Novo Cliente</span>
        </div>
        <div class="card-body">
            @livewire('customer.customer-create-edit')
        </div>
    </div>
</x-app-layout>
