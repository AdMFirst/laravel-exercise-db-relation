<?php

namespace App\Http\Controllers;

use App\Http\Resources\CashResource;
use App\Http\Resources\PaymentResource;
use App\Models\Cash;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JsonResource::collection(Cash::with('payable')->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'amount' => 'required|decimal:0,2', // property of payment 
                'cashTendered' => 'required|decimal:0,2', // property of cash
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }
        $cash = Cash::create([
            'cashTendered' => $request->input('cashTendered')
        ]);

        $payment = Payment::create([
            'amount' => $request->input('amount'),
        ]);
        
        $cash->payable()->save($payment);

        return response([
            'success' => true,
            'message' => 'Data payment cash baru berhasil ditambah',
            'data' => PaymentResource::make($payment) // $cash variable should be filled with both amount and cashtendered
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cash $cash)
    {
        return response([
            'success' => true,
            'message' => 'Data payment cash baru berhasil ditambah',
            'data' => PaymentResource::make($cash->payable)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cash $cash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cash $cash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cash $cash)
    {
        //
    }
}
