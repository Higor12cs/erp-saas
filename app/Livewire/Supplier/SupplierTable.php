<?php

namespace App\Livewire\Supplier;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierTable extends Component
{
    use WithPagination;

    public SupplierForm $form;

    public function render()
    {
        return view('livewire.supplier.supplier-table');
    }

    #[Computed]
    public function suppliers()
    {
        return Supplier::query()
            ->latest()
            ->paginate(10);
    }

    public function delete(string $supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);

        $this->form->set($supplier);
        $this->form->delete();

        unset($this->suppliers);
    }
}
