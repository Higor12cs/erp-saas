<?php

namespace App\Livewire\Order;

use App\Livewire\Forms\OrderForm;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public OrderForm $form;

    public function render()
    {
        return view('livewire.order.order-table');
    }

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->latest()
            ->paginate(10);
    }

    public function delete(string $orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->form->set($order);
        $this->form->delete();

        unset($this->orders);
    }
}
