<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public $params = [];

    public function __construct($resource, ...$params)
    {
        $this->params = array_flip($params);
        parent::__construct($resource);
    }

    public static function collection($resource, ...$params)
    {
        $collection = parent::collection($resource);

        foreach($collection as $res) {
            $res->params = array_flip($params);
        }

        return $collection;
    }

    public function mergeWhenCustom($key, $data)
    {
        if (isset($this->params[$key])) {
            return $this->mergeWhen(true, $data);
        }

        return $this->mergeWhen(false, $data);
    }
}
