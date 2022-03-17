<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Авторизация"},
     *     summary="Авторизация пользователя",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная авторизация",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Серверная ошибка"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Указанные данные недействительны.",
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error(['Неправильное имя пользователя или пароль'], 401);
        }

        return $this->success(['user' => $user->load('roles'), 'token' => $user->createToken('user')->plainTextToken]);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/register",
     *     tags={"Авторизация"},
     *     summary="Создание нового пользователя",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Успешная регистрация",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Серверная ошибка"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Указанные данные недействительны.",
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $user->assignRole('user');
        $user->save();

        $this->success(['user' => $user->load('roles'), 'token' => $user->createToken('user')->plainTextToken], 201);
    }

    public function logout()
    {
        (Auth::user())->currentAccessToken()->delete();
        return $this->success(['message' => ['Вы вышли из системы']]);
    }
}
