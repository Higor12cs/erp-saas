<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Component;

class CustomerCreateEdit extends Component
{
    public CustomerForm $form;

    public function mount(Customer $customer)
    {
        if ($customer->exists) {
            $this->form->set($customer);
        }
    }

    public function render()
    {
        return view('livewire.customer.customer-create-edit');
    }

    public function submit()
    {
        $this->form->save();

        return to_route('customers.index');
    }
}
