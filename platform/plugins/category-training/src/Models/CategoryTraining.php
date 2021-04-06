<?php

namespace Platform\CategoryTraining\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Slug\Traits\SlugTrait;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\PostTraining\Models\PostTraining;

class CategoryTraining extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_category_training';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'icon',
        'is_featured',
        'order',
        'is_default',
        'status',
        'author_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function post_training(): BelongsToMany
    {
        return $this->belongsToMany(PostTraining::class, 'app_post_training_category')->with('slugable');
    }

    /**
     * @return BelongsTo
     */
    public function parent_training(): BelongsTo
    {
        return $this->belongsTo(CategoryTraining::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children_training(): HasMany
    {
        return $this->hasMany(CategoryTraining::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (CategoryTraining $categoryTraining) {
            CategoryTraining::where('parent_id', $categoryTraining->id)->delete();

            $categoryTraining->post_training()->detach();
        });
    }
}
