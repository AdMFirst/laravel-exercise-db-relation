<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $token = $request->user()->createToken('authToken', ['*'], now()->addDays(5))->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful. Welcome!',
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ],
            ], 200);
        } else {
            // Authentication failed
            return response()->json([
                'success' => false,
                'message' => 'Invalid credential',
                'data' => '',
            ], 401);
        }
    }

    function register() {
        
    }

}
