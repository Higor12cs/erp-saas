<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer;

    public bool $edit = false;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $first_name = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $last_name = '';

    public function set(Customer $customer)
    {
        $this->edit = true;
        $this->customer = $customer;
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
    }

    public function save()
    {
        $this->edit ? $this->update() : $this->store();
    }

    public function store()
    {
        $this->validate();

        Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->customer->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
    }

    public function delete()
    {
        // TODO: Verify if the customer has any relationship before deleting it.

        $this->customer->delete();
    }
}
