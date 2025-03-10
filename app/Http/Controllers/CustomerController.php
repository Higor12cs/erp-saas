<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->when(request('search'), function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('legal_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Customers/Index', [
            'customers' => $customers,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Customers/Create');
    }

    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return to_route('customers.index');
    }

    // public function show(Customer $customer)
    // {
    //     //
    // }

    public function edit(Customer $customer)
    {
        return inertia('Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return to_route('customers.index');
    }

    public function destroy(Customer $customer)
    {
        // TODO: Check if the customer has any related data before deleting it

        abort(403, 'Forbidden');

        $customer->delete();

        return to_route('customers.index');
    }

    public function search(Request $request)
    {
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $customers = Customer::whereIn('id', $ids)->get();

            return response()->json([
                'data' => $customers->map(function (Customer $customer) {
                    return [
                        'id' => $customer->id,
                        'name' => $customer->first_name,
                    ];
                }),
            ]);
        }

        $query = $request->search ?? '';
        $customers = Customer::where('first_name', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $customers->map(function (Customer $customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->first_name,
                ];
            }),
        ]);
    }
}
