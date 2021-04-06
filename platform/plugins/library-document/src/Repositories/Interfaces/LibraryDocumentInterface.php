<?php

namespace Platform\LibraryDocument\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;

interface LibraryDocumentInterface extends RepositoryInterface
{
    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByCategoryLibrary($categoryId, $paginate = 12, $limit = 0);

     /**
     * @param int|array $categoryId
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelatedByCategoryDoc($id, $categoryId, $limit = 6);
}
