<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email'=> $request->email, "password"=>$request->password])) {
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

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]    
        );

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors(),
            ], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate a token for the registered user
        $token = $user->createToken('authToken')->plainTextToken;

        // Return a JSON response with the token
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => [
                'user' => $user,
                'auth' => [
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]
            ],
        ], 201);
    }

}
