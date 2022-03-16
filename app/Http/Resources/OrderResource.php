<?php

namespace App\Http\Resources;

use App\Models\User;

class OrderResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
//            $this->mergeWhenCustom('author', [
//                'author' => $this->author,
//            ]),
        ];
    }
}
