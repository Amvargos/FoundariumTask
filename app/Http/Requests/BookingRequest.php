<?php

namespace App\Http\Requests;

use App\Models\Party;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Booking Request",
 *      description="Booking request body data",
 *      type="object",
 *      required={"date_start", "date_end"}
 * )
 */
class BookingRequest extends FormRequest
{

    /**
     * @OA\Property(
     *     title="Date start",
     *     description="Время Начала брони",
     *     example="2022-03-17 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $date_start;

    /**
     * @OA\Property(
     *     title="Date end",
     *     description="Время окончания брони",
     *     example="2022-03-17 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $date_end;

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
