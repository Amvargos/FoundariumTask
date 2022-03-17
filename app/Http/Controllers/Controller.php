<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     description="Тестовое задание для Foundarium",
 *     version="1.0",
 *     title="Foundarium API",
 *     @OA\Contact(
 *         name="Варужан",
 *         email="varujan@ambaryan.ru",
 *     ),
 * )
 *
 * @OA\Server(
 *     description="LocalHost API",
 *     url="http://127.0.0.1:8003/api"
 * )
 *
 * @OA\Tag(
 *     name="Авторизация",
 * )
 * @OA\Tag(
 *     name="Пользователь",
 * )
 * @OA\Tag(
 *     name="Автомобиль",
 * )
 *
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $per_page;

    public function __construct()
    {
        $this->per_page = (int)request()->get('per_page') ?: 10;
    }


    public function success($data, int $code = 200)
    {
        return response()->json($data, $code);
    }

    public function error($errors, int $code = 500)
    {
        return response()->json(['error' => $errors], $code);
    }
}
