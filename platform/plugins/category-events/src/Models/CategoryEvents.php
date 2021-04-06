<?php

namespace Platform\CategoryEvents\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Slug\Traits\SlugTrait;
use Platform\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Platform\PostEvents\Models\PostEvents;

class CategoryEvents extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_category_events';

    protected $with = ['posts_events', 'posts_events_desc'];

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
    public function posts_events(): BelongsToMany
    {
        return $this->belongsToMany(PostEvents::class, 'app_post_events_category')->with('slugable');
    }

    /**
     * @return BelongsToMany
     */
    public function posts_events_desc(): BelongsToMany
    {
        return $this->belongsToMany(PostEvents::class, 'app_post_events_category')->with('slugable')->orderBy('created_at', 'desc');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategoryEvents::class, 'parent_id')->withDefault();
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(CategoryEvents::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (CategoryEvents $categoryevents) {
            CategoryEvents::where('parent_id', $categoryevents->id)->delete();

            $categoryevents->posts_events()->detach();
        });
    }
}
