<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customer. 
     * 
     * @queryParam page integer the page number. Default to 1. Example: 1
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
     * Store a newly created customer in storage.
     * 
     * @response 200 
     *   {
     *       "success": true,
     *       "message": "Data payment baru berhasil ditambah",
     *       "data": {
     *           "amount": "49999.99",
     *           "updated_at": "2023-11-28T08:22:42.000000Z",
     *           "created_at": "2023-11-28T08:22:42.000000Z",
     *           "id": 4
     *       }
     *   }
 
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
     * Display the specified customer.
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
     * Update the specified customer in storage.
     * 
     * @urlParam id integer required id of customer. Example: 1
     * @bodyParam name string the new name that will overwrite the old name
     * @bodyParam address string the new address that will overwrite the old address
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
     * Remove the specified customer from storage.
     * 
     * @urlParam id integer required id of customer. Example: 1
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
