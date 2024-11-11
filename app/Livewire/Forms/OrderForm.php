<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    public ?Order $order;

    public bool $edit = false;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    public $customer_id = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('date', message: 'Este campo deve ser uma data válida.')]
    public $issue_date = '';

    #[Validate('nullable')]
    #[Validate('date', message: 'Este campo deve ser uma data válida.')]
    public $closing_date = '';

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    public $total_cost = 0;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    public $discount = 0;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    public $tax = 0;

    #[Validate('required', message: 'Este campo é obrigatório.')]
    #[Validate('numeric', message: 'Este campo deve ser um valor numérico.')]
    public $total_price = 0;

    public function set(Order $order)
    {
        $this->edit = true;
        $this->order = $order;
        $this->customer_id = $order->customer_id;
        $this->issue_date = $order->issue_date->format('Y-m-d');
        $this->closing_date = $order->closing_date;
        $this->total_cost = number_format($order->total_cost, 2, ',', '.');
        $this->discount = number_format($order->discount, 2, ',', '.');
        $this->tax = number_format($order->tax, 2, ',', '.');
        $this->total_price = number_format($order->total_price, 2, ',', '.');
    }

    public function save()
    {
        $this->total_cost = $this->convertToFloat($this->total_cost);
        $this->discount = $this->convertToFloat($this->discount);
        $this->tax = $this->convertToFloat($this->tax);
        $this->total_price = $this->convertToFloat($this->total_price);

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

        Order::create($this->all());
    }

    public function update()
    {
        $this->validate();

        $this->order->update($this->all());
    }

    public function delete()
    {
        // TODO: Verify if the order has any relationship before deleting it.

        $this->order->delete();
    }
}
