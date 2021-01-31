<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create($request->all());

        return response()->noContent();
    }

    public function login(LoginRequest $request)
    {
        if (!auth()->guard()->attempt($request->only('email', 'password'), $request->remember))
            throw new AuthenticationException();

        return response()->noContent();
    }

    public function logout()
    {
        auth()->guard('web')->logout();

        return response()->noContent();
    }
}
