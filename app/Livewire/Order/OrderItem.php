<?php

namespace App\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class OrderItem extends Component
{
    public Order $order;
    
    public function mount(Order $order)
    {
        dd($order);
    }

    public function render()
    {
        return view('livewire.order.order-item');
    }
}
