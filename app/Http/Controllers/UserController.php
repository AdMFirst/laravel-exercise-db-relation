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
    
    /**
     * A Login function to receive your authorization token
     * 
     * @group User Authentication
     * @unauthenticated
     * @bodyParam email string required your email used to make account. Example: scribe.bot@example.com
     * @bodyParam password string required your password used then making the account. Example: password
     * 
     * @response 200 {"success": true,"message": "Login successful. Welcome!","data": {"access_token": "you_access_token_here_12345","token_type": "Bearer"}}
     * @response 422 {"success":false,"message":"Validation error!","data":{"email":["The email field is required."],"password":["The password field is required."]}}
     * @response 401 {"success":false,"message":"Invalid credential","data":""}
     */
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

    /**
     * A Register function to add account to the system
     * 
     * @group User Authentication
     * @unauthenticated
     * 
     * @bodyParam name string required name for registration. Example: John Doe
     * @bodyParam email string required a valid email used for registration. Example: John.Doe@example.com
     * @bodyParam password string required a strong password for your account. minimum length is 8. Example: helloworld!
     * 
     * @response 200 {
     *       "success": true,
     *       "message": "User created successfully",
     *       "data": {
     *           "user": {
     *               "name": "John Doe",
     *               "email": "John.Doe@example.com",
     *               "updated_at": "2023-11-28T07:18:36.000000Z",
     *               "created_at": "2023-11-28T07:18:36.000000Z",
     *               "id": 32
     *           },
     *           "auth": {
     *               "access_token": "your_access_token_here_1234",
     *               "token_type": "Bearer"
     *           }
     *       }
     *   }
     * @response 422 {"success":false,"message":"Validation error!","data":{"name":["The name field is required."],"email":["The email field is required."],"password":["The password field is required."]}}
     * 
     */
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
        $token = $user->createToken('authToken', ['*'], now()->addDays(5))->plainTextToken;

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
