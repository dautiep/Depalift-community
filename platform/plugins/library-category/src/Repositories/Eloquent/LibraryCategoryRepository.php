<?php

namespace Platform\LibraryCategory\Repositories\Eloquent;

use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;

class LibraryCategoryRepository extends RepositoriesAbstract implements LibraryCategoryInterface
{

	public function getAllCategories(array $condition = [], array $with = [], array $select = ['*'])
	{
		// TODO: Implement getAllCategories() method.
		$data = $this->model
			->where($condition)
			->with($with)
			->select($select);

		return $this->applyBeforeExecuteQuery($data)->get();
	}

	public function getCategoryByDoc($id){
		$data = $this->model
			->join('app_library_documents', 'app_library_documents.library_category_id', '=', 'app_library_categories.id')
			->where('app_library_documents.id', '=' ,$id)
			->select('app_library_categories.*')
			->with('slugable');
        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
