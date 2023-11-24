<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource. 
     * 
     * @queryParam page integer the page number. Default to 1
     */
    public function index()
    {
        //
        $customers = Customer::latest()->paginate(5);

        return response([
            'success' => true,
            'message' => 'List data customer',
            'data' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'address' => 'required|string'
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'address' => $request->address
        ]);

        return response([
            'success' => true,
            'message' => 'Data customer baru berhasil ditambah',
            'data' => $customer,
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @urlParam id integer required id of customer. Example: 1
     */
    public function show(Customer $customer)
    {
        //
        return response([
            'success' => true,
            'message' => 'Berikut adalah data customer yang diminta',
            'data' => $customer,
        ]);
    }


    /**
     * Update the specified resource in storage.
     * 
     * @urlParam id integer required id of customer. Example: 1
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'string',
                'address' => 'string'
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        if ($request->name) {
            $customer->name = $request->name;
        };

        if ($request->address) {
            $customer->address = $request->address;
        };

        $customer->save();

        return response([
            'success' => true,
            'message' => 'Data customer berhasil diubah',
            'data' => $customer,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @urlParam id integer required id of customer. Example: 10
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);

        return response([
            'success' => true,
            'message' => 'Data customer berhasil dihapus',
            'data' => null,
        ]);
    }
}
