<?php

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;

if (!function_exists('get_library_catrgories')) {
	/**
	 * @return array
	 * @throws Exception
	 */
	function get_library_catrgories()
	{
		$data = [];

		$categories = app(LibraryCategoryInterface::class)
			->getAllCategories(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name'])->pluck('name','id')->toArray();


		if (!blank($categories)) {
		    $data = $categories;
		}

		return $data;
	}
}