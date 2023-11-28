<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payment superclass.
     * 
     * @queryParam page integer the page number. Default to 1
     */
    public function index()
    {
        //
        return PaymentResource::collection(Payment::paginate());
    }

    /**
     * Store a newly created payment superclass in storage.
     * 
     * @bodyParam amount decimal the new amount value that will overwrite the old value. Example: 49999.99
     * 
     * @response 200 {"success":true,"message":"Data payment baru berhasil ditambah","data":{"amount":"843.58","updated_at":"2023-11-28T08:29:07.000000Z","created_at":"2023-11-28T08:29:07.000000Z","id":7}}
     * @response 422 {"success":false,"message":"Validation error!","data":{"amount":["The amount field must have 0-2 decimal places."]}}
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),
            [
                'amount' => 'required|decimal:0,2',
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        $payment = Payment::create([
            'amount' => $request->amount,
        ]);

        return response([
            'success' => true,
            'message' => 'Data payment baru berhasil ditambah',
            'data' => PaymentResource::make($payment),
        ]);
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        //
        return PaymentResource::make($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified payment in storage.
     * 
     * @urlParam id integer required id of the payment. Example: 3
     * @bodyParam amount decimal the new amount value that will overwrite the old value. Example: 20000.00
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(),
            [
                'amount' => 'decimal:0,2',
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        if ($request->amount)
        {
            $payment->setAttribute('amount', $request->amount);
        }
        $payment->saveOrFail();

        return response([
            'success' => true,
            'message' => 'Data payment baru berhasil ditambah',
            'data' => PaymentResource::make($payment),
        ]);
    }

    /**
     * Remove the specified payment from storage.
     * 
     * @urlParam id integer required id of customer. Example: 10
     */
    public function destroy(Payment $payment)
    {
        $payment->deleteOrFail();

        return response()->noContent();
    }
}
