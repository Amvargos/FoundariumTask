<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
        return response()->json(['data' => $data], $code);
    }

    public function error($errors, int $code = 500)
    {
        return response()->json(['error' => $errors], $code);
    }
}
