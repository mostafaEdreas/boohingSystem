<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Sevices\UserService;
use Illuminate\Support\Facades\Hash;

 class AuthController extends Controller 
 {

    protected $userService;
     /**
      * Create a new controller instance.
      *
      * @return void
      */
     public function __construct(UserService $userService)
     {
        $this->userService = $userService;
         $this->middleware('guest')->except('logout');
         $this->middleware('auth:api')->only('logout');
     }

    /**
     * Handle a registration request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function register(RegisterRequest $request)
    {
        $data['user'] = $this->userService->createUser($request->validated());
        $data['token'] = $this->generateToken($data['user']);

        return response()->json(['data' => $data ,'message' => 'User registered successfully']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request )
    {
        $user = $this->checkCredentials($request->validated());
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $this->generateToken($user);

        return response()->json(['data' => ['user' => $user, 'token' => $token], 'message' => 'Login successful']);
    }

    /**
     * Handle a logout request to the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->revokeToken(auth()->user());

        return response()->json(['message' => 'Logout successful']);
    }



 }