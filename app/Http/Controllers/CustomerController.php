<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'iban' => 'required|string|max:35|unique:customers,iban',
        ]);

        $customer = Customer::create($request->only(['name', 'email', 'iban']));

        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:customers,email,' . $customer->id,
            'iban' => 'sometimes|required|string|max:35|unique:customers,iban,' . $customer->id,
        ]);

        $customer->update($request->only(['name', 'email', 'iban']));

        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
