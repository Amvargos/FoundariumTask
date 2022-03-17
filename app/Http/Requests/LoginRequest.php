<?php

namespace App\Http\Requests;

use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Login User Request",
 *      description="Login user request body data",
 *      type="object",
 *      required={"email", "password"}
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="E-Mail пользователя",
     *      example="varujan@ambaryan.ru"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Пароль пользователя",
     *      example="qwerty123456"
     * )
     *
     * @var string
     */
    public $password;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }
}
