<?php

namespace App\Http\Requests;

use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
        ];
    }
}
