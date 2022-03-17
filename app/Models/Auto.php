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

/**
 * @OA\Schema(
 *     title="Auto",
 *     description="Auto model",
 *     @OA\Xml(
 *         name="Auto"
 *     )
 * )
 */
class Auto extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Название",
     *      description="Название машины",
     *      example="Jaguar XF"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Время создания",
     *     example="2022-03-17 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Время обновления",
     *     example="2022-03-17 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    const AUTO_PICTURE = 'auto_picture';

    protected $fillable = [
        'title',
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
