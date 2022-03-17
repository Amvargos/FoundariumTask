<?php

namespace App\Http\Requests;

use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Register User Request",
 *      description="Register user request body data",
 *      type="object",
 *      required={"name","email","password"}
 * )
 */
class RegisterRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Имя нового пользователя",
     *      example="Варужан"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="E-Mail нового пользователя",
     *      example="varujan@ambaryan.ru"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Пароль нового пользователя",
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }
}
