<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }
    public function registerUser(array $data)
    {
       $role = $data['role'] ?? 'user';

    if ($role !== 'user') {
        $canCreate = Gate::allows('create-user-with-role');
        logger("Can current user create with role? " . ($canCreate ? 'YES' : 'NO'));

        Gate::authorize('create-user-with-role');
    }

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $role,
    ]);

    return $user;
        }
    }
    

