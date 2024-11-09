<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    public bool $edit = false;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $first_name = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $last_name = '';

    public function set(Supplier $supplier)
    {
        $this->edit = true;
        $this->supplier = $supplier;
        $this->first_name = $supplier->first_name;
        $this->last_name = $supplier->last_name;
    }

    public function save()
    {
        $this->edit ? $this->update() : $this->store();
    }

    public function store()
    {
        $this->validate();

        Supplier::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->supplier->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);
    }

    public function delete()
    {
        // TODO: Verify if the supplier has any relationship before deleting it.

        $this->supplier->delete();
    }
}
