<?php

namespace App\Livewire\Product;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public ProductForm $form;

    public function render()
    {
        return view('livewire.product.product-table');
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->latest()
            ->paginate(10);
    }

    public function delete(string $productId)
    {
        $product = Product::findOrFail($productId);

        $this->form->set($product);
        $this->form->delete();

        unset($this->products);
    }
}
