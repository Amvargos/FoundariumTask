<?php

namespace App\Http\Requests;

use App\Models\Auto;
use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

class StoreAutoRequest extends FormRequest
{
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
