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

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/autos",
     *     tags={"Автомобиль"},
     *     summary="Список все автомобилей",
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос",
     *         @OA\JsonContent(ref="#/components/schemas/Auto")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function index()
    {
        $query = Auto::orderBy('id', 'desc');

        $autos = $query->paginate($this->per_page);

        return AutoResource::collection($autos);
    }

    /**
     * @param StoreAutoRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/autos",
     *     tags={"Автомобиль"},
     *     summary="Создание нового автомобиля",
     *      @OA\RequestBody(
     *           @OA\JsonContent(ref="#/components/schemas/StoreAutoRequest"),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Автомобиль успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Auto")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Серверная ошибка"
     *      ),
     *          *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Указанные данные недействительны.",
     *     ),
     * )
     */
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

    /**
     * @param Auto $auto
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/autos/{id}",
     *     tags={"Автомобиль"},
     *     summary="Информация об автомобиле",
     *     @OA\Parameter(
     *         name="id",
     *         description="Auto id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос",
     *         @OA\JsonContent(ref="#/components/schemas/Auto")
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function show(Auto $auto)
    {
        return new AutoResource($auto);
    }

    /**
     * @param Auto $auto
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/autos/{id}",
     *      tags={"Автомобиль"},
     *      summary="Обновление информации об автомобиле",
     *      @OA\Parameter(
     *          name="id",
     *          description="Auto id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreAutoRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успшено сохранено",
     *          @OA\JsonContent(ref="#/components/schemas/Auto")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
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

    /**
     * @param Auto $auto
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/auto/{id}/booking",
     *      tags={"Автомобиль"},
     *      summary="Бронирование автомобиля",
     *      @OA\Parameter(
     *          name="id",
     *          description="Auto id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BookingRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успшено забронировано",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
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

    /**
     * @param Auto $auto
     *
     * @OA\Delete(
     *     path="/autos/{id}",
     *     tags={"Автомобиль"},
     *     summary="Удалить автомобиль",
     *     @OA\Parameter(
     *         name="id",
     *         description="Auto id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     * )
     */
    public function destroy(Auto $auto)
    {
        $auto->delete();
    }
}
