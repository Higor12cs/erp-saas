<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    public CustomerForm $form;

    public function render()
    {
        return view('livewire.customer.customer-table');
    }

    #[Computed]
    public function customers()
    {
        return Customer::query()
            ->latest()
            ->paginate(10);
    }

    public function delete(string $customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $this->form->set($customer);
        $this->form->delete();

        unset($this->customers);
    }
}
