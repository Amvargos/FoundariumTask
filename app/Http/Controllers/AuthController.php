<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error(['Неправильное имя пользователя или пароль'], 401);
        }

        return $this->success(['user' => $user->load('roles'), 'token' => $user->createToken('user')->plainTextToken]);
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $user->assignRole('user');
        $user->save();

        $this->success(['user' => $user->load('roles'), 'token' => $user->createToken('user')->plainTextToken]);
    }

    public function logout()
    {
        (Auth::user())->currentAccessToken()->delete();
        return $this->success(['message' => ['Вы вышли из системы']]);
    }
}
