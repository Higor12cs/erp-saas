<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }

    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return response()->json(['message' => 'Customer created successfully'], 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json(['message' => 'Customer updated successfully']);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
