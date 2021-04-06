<?php

namespace Platform\PostEvents\Models;

use Platform\ACL\Models\User;
use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Revision\RevisionableTrait;
use Platform\Slug\Traits\SlugTrait;
use Platform\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Platform\CategoryEvents\Models\CategoryEvents;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class PostEvents extends BaseModel implements Searchable
{
    use RevisionableTrait;
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_post_events';

    /**
     * @var mixed
     */
    protected $revisionEnabled = true;

    /**
     * @var mixed
     */
    protected $revisionCleanup = true;

    /**
     * @var int
     */
    protected $historyLimit = 20;

    /**
     * @var array
     */
    protected $dontKeepRevisionOf = [
        'content',
        'views',
    ];

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
        'content',
        'image',
        'is_featured',
        'format_type',
        'status',
        'author_id',
        'author_type',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @deprecated
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * @return BelongsToMany
     */
    public function categories_events(): BelongsToMany
    {
        return $this->belongsToMany(CategoryEvents::class, 'app_post_events_category');
    }

    /**
     * @return MorphTo
     */
    public function author(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (PostEvents $postEvents) {
            $postEvents->categories_events()->detach();
        });
    }

    public function getSearchResult(): SearchResult
    {
        // TODO: Implement getSearchResult() method.
        $url = route('events.detail', $this->slug);

        return new SearchResult($this, $this->name, $url);
    }
}
