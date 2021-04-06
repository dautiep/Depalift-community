<?php

namespace Platform\LibraryCategory\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;

class LibraryCategoryCacheDecorator extends CacheAbstractDecorator implements LibraryCategoryInterface
{

	public function getAllCategories(array $condition = [], array $with = [], array $select = ['*'])
	{
		// TODO: Implement getAllCategories() method.
		return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
	}

	/**
     * {@inheritDoc}
     */
    public function getCategoryByDoc($id)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
