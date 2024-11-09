<?php

namespace App\Livewire\Product;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Component;

class ProductCreateEdit extends Component
{
    public ProductForm $form;

    public function mount(Product $product)
    {
        if ($product->exists) {
            $this->form->set($product);
        }
    }

    public function render()
    {
        return view('livewire.product.product-create-edit');
    }

    public function submit()
    {
        $this->form->save();

        return to_route('products.index');
    }
}
