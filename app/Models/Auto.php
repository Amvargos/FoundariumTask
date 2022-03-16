<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     *
     */
    public  function active_orders()
    {
        return $this->hasMany(Order::class)
            ->where([
                ['date_end', '>=', Carbon::now()->toDateTimeString()]
            ]);
    }

    /**
     * Связь с заказами
     *
     */
    public  function orders()
    {
        return $this->hasMany(Order::class);
    }
}
