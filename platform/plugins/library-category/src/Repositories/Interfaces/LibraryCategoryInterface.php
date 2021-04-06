<?php

namespace Platform\LibraryCategory\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;

interface LibraryCategoryInterface extends RepositoryInterface
{
	public function getAllCategories(array $condition = [], array $with = [], array $select = ['*']);

	/**
     * @param int $id
     * @return mixed
     */
    public function getCategoryByDoc($id);
}
