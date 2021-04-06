<?php

namespace Platform\PostAssociates\Models;

use Platform\ACL\Models\User;
use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Revision\RevisionableTrait;
use Platform\Slug\Traits\SlugTrait;
use Platform\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Platform\CategoryAssociates\Models\CategoryAssociates;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class PostAssociates extends BaseModel implements Searchable
{
    use RevisionableTrait;
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_post_associates';

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
        'create_url',
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
    public function categories_associates(): BelongsToMany
    {
        return $this->belongsToMany(CategoryAssociates::class, 'app_post_associates_category');
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

        static::deleting(function (PostAssociates $postAssociates) {
            $postAssociates->categories_associates()->detach();
        });
    }

    public function getSearchResult(): SearchResult
    {
        // TODO: Implement getSearchResult() method.
        $url = $this->create_url;

        return new SearchResult($this, $this->name, $url);
    }
}
