<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AutoResource;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
     *  Авторизация пользователя
     *
     */
    public function token(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->error(['error' => 'Неправильное имя пользователя или пароль'], 401);
        }

        $this->success(['token' => $user->createToken('user')->plainTextToken]);
    }

    /*
     * Регистрация пользователя
     *
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $this->success(['token' => $user->createToken('user')->plainTextToken]);
    }
}
