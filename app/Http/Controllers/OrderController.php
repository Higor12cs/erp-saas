<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['createdBy'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function create()
    {
        return Inertia::render('Orders/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'fees' => 'nullable|numeric|min:0',
            'observation' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.fees' => 'nullable|numeric|min:0',
        ]);

        $totalCost = 0;
        $totalPrice = 0;
        $items = [];

        foreach ($validated['items'] as $index => $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $unitCost = $product->cost;
            $unitPrice = $item['unit_price'];
            $itemDiscount = $item['discount'] ?? 0;
            $itemFees = $item['fees'] ?? 0;

            $itemTotalCost = $unitCost * $quantity;
            $itemTotalPrice = ($unitPrice * $quantity) - $itemDiscount + $itemFees;

            $totalCost += $itemTotalCost;
            $totalPrice += $itemTotalPrice;

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'unit_price' => $unitPrice,
                'discount' => $itemDiscount,
                'fees' => $itemFees,
                'total_cost' => $itemTotalCost,
                'total_price' => $itemTotalPrice,
                'created_by' => Auth::id(),
            ];
        }

        $orderDiscount = $validated['discount'] ?? 0;
        $orderFees = $validated['fees'] ?? 0;
        $finalTotalPrice = $totalPrice - $orderDiscount + $orderFees;

        DB::transaction(function () use ($validated, $totalCost, $orderDiscount, $orderFees, $finalTotalPrice, $items) {
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'issue_date' => $validated['issue_date'],
                'total_cost' => $totalCost,
                'discount' => $orderDiscount,
                'fees' => $orderFees,
                'total_price' => $finalTotalPrice,
                'observation' => $validated['observation'] ?? null,
                'created_by' => Auth::id(),
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }
        });

        return to_route('orders.index')->with('success', 'Pedido criado com sucesso.');
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'createdBy']);

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    public function edit(Order $order)
    {
        $order->load(['items.product', 'createdBy']);

        return Inertia::render('Orders/Edit', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'issue_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'fees' => 'nullable|numeric|min:0',
            'observation' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:order_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.fees' => 'nullable|numeric|min:0',
        ]);

        $totalCost = 0;
        $totalPrice = 0;
        $items = [];
        $existingItemIds = [];

        foreach ($validated['items'] as $index => $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $unitCost = $product->cost;
            $unitPrice = $item['unit_price'];
            $itemDiscount = $item['discount'] ?? 0;
            $itemFees = $item['fees'] ?? 0;

            $itemTotalCost = $unitCost * $quantity;
            $itemTotalPrice = ($unitPrice * $quantity) - $itemDiscount + $itemFees;

            $totalCost += $itemTotalCost;
            $totalPrice += $itemTotalPrice;

            $itemData = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'unit_price' => $unitPrice,
                'discount' => $itemDiscount,
                'fees' => $itemFees,
                'total_cost' => $itemTotalCost,
                'total_price' => $itemTotalPrice,
                'created_by' => Auth::id(),
            ];

            if (isset($item['id'])) {
                $existingItemIds[] = $item['id'];
                $items[] = array_merge(['id' => $item['id']], $itemData);
            } else {
                $items[] = $itemData;
            }
        }

        $orderDiscount = $validated['discount'] ?? 0;
        $orderFees = $validated['fees'] ?? 0;
        $finalTotalPrice = $totalPrice - $orderDiscount + $orderFees;

        DB::transaction(function () use ($order, $validated, $totalCost, $orderDiscount, $orderFees, $finalTotalPrice, $items, $existingItemIds) {
            $order->update([
                'customer_id' => $validated['customer_id'],
                'issue_date' => $validated['issue_date'],
                'total_cost' => $totalCost,
                'discount' => $orderDiscount,
                'fees' => $orderFees,
                'total_price' => $finalTotalPrice,
                'observation' => $validated['observation'] ?? null,
            ]);

            $order->items()->whereNotIn('id', $existingItemIds)->delete();

            foreach ($items as $item) {
                if (isset($item['id'])) {
                    $order->items()->where('id', $item['id'])->update($item);
                } else {
                    $order->items()->create($item);
                }
            }
        });

        return to_route('orders.index')->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return to_route('orders.index')
            ->with('success', 'Pedido excluído com sucesso.');
    }

    public function search(Request $request)
    {
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $orders = Order::whereIn('id', $ids)->get();
            return response()->json([
                'data' => $orders->map(function (Order $order) {
                    return [
                        'id' => $order->id,
                        'name' => 'Pedido #' . $order->sequential_id . ' - ' . $order->issue_date->format('d/m/Y'),
                        'total' => $order->total_price,
                    ];
                })
            ]);
        }

        $query = $request->search ?? '';
        $orders = Order::where('sequential_id', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $orders->map(function (Order $order) {
                return [
                    'id' => $order->id,
                    'name' => 'Pedido #' . $order->sequential_id . ' - ' . $order->issue_date->format('d/m/Y'),
                    'total' => $order->total_price,
                ];
            })
        ]);
    }
}
