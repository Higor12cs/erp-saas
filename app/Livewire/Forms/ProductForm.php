<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    public ?Product $product;

    public bool $edit = false;

    public $sku = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $name = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    #[Validate('gt:0', message: 'O valor deve ser maior do que zero.')]
    public $cost = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    #[Validate('gt:0', message: 'O valor deve ser maior do que zero.')]
    public $price = '';

    public function set(Product $product)
    {
        $this->edit = true;
        $this->product = $product;
        $this->sku = $product->sku;
        $this->name = $product->name;
        // $this->cost = $product->cost;
        // $this->price = $product->price;
        $this->cost = number_format($product->cost, 2, ',', '.');
        $this->price = number_format($product->price, 2, ',', '.');
    }

    public function save()
    {
        $this->cost = $this->convertToFloat($this->cost);
        $this->price = $this->convertToFloat($this->price);

        $this->edit ? $this->update() : $this->store();
    }

    private function convertToFloat($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }

    public function store()
    {
        $this->validate();

        Product::create([
            'sku' => $this->sku,
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->product->update([
            'sku' => $this->sku,
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
        ]);
    }

    public function delete()
    {
        // TODO: Verify if the product has any relationship before deleting it.

        $this->product->delete();
    }
}
