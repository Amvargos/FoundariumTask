<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/getUser",
     *     tags={"Пользователь"},
     *     summary="Информация об авторизованном пользователе",
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Серверная ошибка"
     *     ),
     * )
     */
    public function getUser()
    {
        return new UserResource(auth()->user()->load('roles'));
    }
}
