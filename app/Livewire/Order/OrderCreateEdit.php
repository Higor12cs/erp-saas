<?php

namespace App\Livewire\Order;

use App\Livewire\Forms\OrderForm;
use App\Models\Customer;
use App\Models\Order;
use Livewire\Component;

class OrderCreateEdit extends Component
{
    public OrderForm $form;

    public function mount(Order $order)
    {
        if ($order->exists) {
            $this->form->set($order);
        } else {
            $this->form->issue_date = now()->toDateString();
        }
    }

    public function render()
    {
        return view('livewire.order.order-create-edit', [
            'customers' => Customer::query()
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function submit()
    {
        $this->form->save();

        return to_route('orders.index');
    }
}
