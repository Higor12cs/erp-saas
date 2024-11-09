<?php

namespace App\Livewire\Supplier;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Component;

class SupplierCreateEdit extends Component
{
    public SupplierForm $form;

    public function mount(Supplier $supplier)
    {
        if ($supplier->exists) {
            $this->form->set($supplier);
        }
    }

    public function render()
    {
        return view('livewire.supplier.supplier-create-edit');
    }

    public function submit()
    {
        $this->form->save();

        return to_route('suppliers.index');
    }
}
