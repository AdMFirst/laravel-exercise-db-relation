<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Cash::paginate()
        ]);
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
                'amount' => 'required|decimal:0,2',
                'cashTendered' => 'required|decimal:0,2',
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
            'amount' => $request->input('amount'),
        ]);
        $cash = $payment->cash()->create([
            'cashTendered' => $request->input('cashTendered')
        ]);

        return response([
            'success' => true,
            'message' => 'Data payment cash baru berhasil ditambah',
            'data' => [
                "cash" => $cash,
                "payment" => $payment,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cash $cash)
    {
        //
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
