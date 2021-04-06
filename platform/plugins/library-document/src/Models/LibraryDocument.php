<?php

namespace Platform\LibraryDocument\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;
use Platform\LibraryCategory\Models\LibraryCategory;
use Platform\Slug\Traits\SlugTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class LibraryDocument extends BaseModel implements Searchable
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_library_documents';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'featured',
        'library_category_id',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

	public function category()
	{
		return $this->belongsTo(LibraryCategory::class, 'library_category_id', 'id')->withDefault();
    }
    
    public function getSearchResult(): SearchResult
    {
        // TODO: Implement getSearchResult() method.
        $url = route('libraries.detail',[$this->category->slug, $this->slug]);

        return new SearchResult($this, $this->name, $url);
    }
}
