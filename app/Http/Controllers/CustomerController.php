<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

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
}
