<?php

namespace App\Http\Resources;

use App\Models\Auto;
use App\Models\User;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */
class UserResource extends BaseResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\User
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
