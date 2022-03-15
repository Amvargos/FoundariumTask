<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\AutoResource;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoController extends Controller
{
    public function index()
    {
        $query = Auto::orderBy('id', 'desc');

        $autos = $query->paginate($this->per_page);

        return AutoResource::collection($autos);
    }

    public function booking(BookingRequest $request, Auto $auto){
        $auto->orders()->create([
            'user_id' => Auth::user()->id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);

        $this->success(['Машина успешно забронирована']);
    }
}
