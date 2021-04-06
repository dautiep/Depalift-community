<?php

namespace Platform\CategoryAssociates\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Slug\Traits\SlugTrait;
use Platform\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\PostAssociates\Models\PostAssociates;

class CategoryAssociates extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_category_associates';

    protected $with = ['post_associates'];

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
    public function post_associates(): BelongsToMany
    {
        return $this->belongsToMany(PostAssociates::class, 'app_post_associates_category')->with('slugable')->orderBy('created_at', 'desc');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategoryAssociates::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(CategoryAssociates::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (CategoryAssociates $categoryAssociates) {
            CategoryAssociates::where('parent_id', $categoryAssociates->id)->delete();

            $categoryAssociates->post_associates()->detach();
        });
    }
}
