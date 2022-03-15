<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Auto extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const AUTO_PICTURE = 'auto_picture';

    protected $fillable = [
        'title',
        'brand',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AUTO_PICTURE)
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('optimized')
                    ->optimize(
                    [
                        Jpegoptim::class => [
                            '--all-progressive',
                            '-m30',
                            '-strip-al',
                        ],
                        Pngquant::class => [
                            '--force'
                        ]
                    ]);
            });
    }

    /**
     * Связь с активным заказом
     * @return HasMany
     */
    public  function active_order(): HasMany
    {
        return $this->hasMany(Order::class, 'auto_id')
            ->where([
                ['date_start', '>', Carbon::today()->toDateString()],
                ['date_end', '<', Carbon::today()->toDateString()]
            ]);
    }

    /**
     * Связь с заказами
     * @return HasMany
     */
    public  function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'auto_id');
    }
}
