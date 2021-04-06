<?php

namespace Platform\LibraryCategory\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;
use Platform\LibraryDocument\Models\LibraryDocument;
use Platform\Slug\Traits\SlugTrait;

class LibraryCategory extends BaseModel
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_library_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
		'image',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

	public function documents()
	{
		return $this->hasMany(LibraryDocument::class);
    }
}
