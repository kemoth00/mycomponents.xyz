<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateUserTokenAction;
use App\Http\Requests\AuthController\Login;
use App\Http\Requests\AuthController\Register;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected CreateUserTokenAction $createUserTokenAction;

    public function __construct(CreateUserTokenAction $createUserTokenAction)
    {
        $this->createUserTokenAction = $createUserTokenAction;
    }

    public function show()
    {
        $user = auth()->user();

        $user->load('interactions');

        return UserResource::make($user);
    }

    public function register(Register $request)
    {
        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'token' => $this->createUserTokenAction->handle($user),
            'user' => UserResource::make($user),
        ]);
    }

    public function login(Login $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $this->createUserTokenAction->handle($user),
            'user' => UserResource::make($user),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
        ]);
    }
}
