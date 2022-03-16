<?php

namespace App\Http\Resources;

use App\Models\Auto;
use App\Models\User;

class AutoResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->title,
            'brand' => $this->brand,
            Auto::AUTO_PICTURE => new MediaResource($this->getFirstMedia(Auto::AUTO_PICTURE)),
            'active_orders' => OrderResource::collection($this->active_orders ? $this->active_orders : null),
        ];
    }
}
