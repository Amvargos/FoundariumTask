<?php

namespace App\Http\Requests;

use App\Models\Auto;
use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 * @OA\Schema(
 *      title="Store Auto Request",
 *      description="Store auto request body data",
 *      type="object",
 *      required={"title","auto_picture"}
 * )
 *
 */
class StoreAutoRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Название",
     *      description="Название нового автомобиля",
     *      example="Jaguar XF"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Картинка",
     *      description="Картинка нового автомобиля",
     * )
     *
     * @var object
     */
    public $auto_picture;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            Auto::AUTO_PICTURE . '.*' => ['required', 'image', 'max:5048'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
            Auto::AUTO_PICTURE => 'Фото автомобиля'
        ];
    }
}
