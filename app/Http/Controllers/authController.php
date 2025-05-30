<?php

namespace App\Http\Controllers;


use App\Http\Requests\user\loginUserRequest;
use App\Http\Requests\user\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    use Authorizable;
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
   
    
    public function register(RegisterUserRequest $request)
    {
   
        $user = $this->authService->registerUser($request->validated());

        return $this->success(['user' => $user, 'message' => 'User registered successfully'], 201);
    }

    public function login(loginUserRequest $request)
    {

    if (!Auth::attempt($request->only('email', 'password'))) {
        return $this->error([
            'message' => 'Invalid email or password'
        ], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken;

    return $this->success([
        'user' => $user,
        'token' => $token
    ], 200);
    }
    

   


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(['message' => 'Logged out']);
}
}