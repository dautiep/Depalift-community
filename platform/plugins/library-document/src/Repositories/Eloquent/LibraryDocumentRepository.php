<?php

namespace Platform\LibraryDocument\Repositories\Eloquent;

use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;

class LibraryDocumentRepository extends RepositoriesAbstract implements LibraryDocumentInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByCategoryLibrary($categoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->join('app_library_categories', 'app_library_documents.library_category_id', '=', 'app_library_categories.id')
            ->whereIn('app_library_documents.library_category_id', $categoryId)
            ->select('app_library_documents.*')
            ->with('slugable')
            ->orderBy('app_library_documents.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

     public function getRelatedByCategoryDoc($id, $categoryId, $limit = 6)
     {
         if (!is_array($categoryId)) {
             $categoryId = [$categoryId];
         }
 
         $data = $this->model
             ->where('app_library_documents.id', '!=', $id)
             ->where('app_library_documents.library_category_id', '=', $categoryId)
             ->join('app_library_categories', 'app_library_documents.library_category_id', '=', 'app_library_categories.id')
             ->select('app_library_documents.*')
             ->with('slugable')
             ->orderBy('app_library_documents.created_at', 'desc');
 
         return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
     }
}
