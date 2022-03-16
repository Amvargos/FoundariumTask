<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\StoreAutoRequest;
use App\Http\Resources\AutoResource;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AutoController extends Controller
{
    public function index()
    {
        $query = Auto::orderBy('id', 'desc');

        $autos = $query->paginate($this->per_page);

        return AutoResource::collection($autos);
    }

    public function store(StoreAutoRequest $request)
    {
        $auto = new Auto();
        $auto->fill($request->validated());
        $auto->save();

        if ($request->hasFile(Auto::AUTO_PICTURE)) {
            $file = $request->file(Auto::AUTO_PICTURE);
            $file_name = Str::random(15) . '.' . $file->extension();
            $auto->addMedia($file)
                ->usingFileName($file_name)
                ->toMediaCollection(Auto::AUTO_PICTURE);
        }

        return new AutoResource($auto->refresh());
    }

    public function show(Auto $auto)
    {
        return new AutoResource($auto);
    }

    public function update(StoreAutoRequest $request, Auto $auto)
    {
        $auto->update($request->validated());

        if ($request->hasFile(Auto::AUTO_PICTURE)) {
            $file = $request->file(Auto::AUTO_PICTURE);
            $file_name = Str::random(15) . '.' . $file->extension();
            $auto->addMedia($file)
                ->usingFileName($file_name)
                ->toMediaCollection(Auto::AUTO_PICTURE);
        }

        return new AutoResource($auto);
    }

    public function booking(BookingRequest $request, Auto $auto){
        $active_orders = $auto->orders()
            ->whereBetween('date_start',[$request->date_start, $request->date_end])
            ->whereBetween('date_end',[$request->date_start, $request->date_end])->count();
        if(!$active_orders) {
            if(!Auth::user()->active_orders) {
                $auto->orders()->create([
                    'user_id' => Auth::user()->id,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                ]);

                return $this->success(['success' => 'Машина успешно забронирована']);
            }else{
                return $this->error(['У вас уже есть активная бронь'], 400);
            }
        }else{
            return $this->error(['Машина уже забронирована на эти даты'], 400);
        }
    }

    public function destroy(Auto $auto)
    {
        $auto->delete();
    }
}
