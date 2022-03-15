<?php

namespace App\Http\Resources;

use App\Models\User;

class AutoResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'active_order' => new OrderResource($this->active_order),
        ];
    }
}
