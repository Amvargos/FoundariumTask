<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'auto_id',
        'date_start',
        'date_end',
    ];

    /**
     * Связь с пользователем
     * @return HasMany
     */
    public  function author(): HasMany
    {
        return $this->hasOne(User::class, 'user_id');
    }

    /**
     * Связь с машиной
     * @return HasMany
     */
    public  function auto(): HasMany
    {
        return $this->hasOne(Auto::class, 'auto_id');
    }
}
