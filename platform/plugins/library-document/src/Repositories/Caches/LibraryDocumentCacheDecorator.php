<?php

namespace Platform\LibraryDocument\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;

class LibraryDocumentCacheDecorator extends CacheAbstractDecorator implements LibraryDocumentInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByCategoryLibrary($categoryId, $paginate = 12, $limit = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedByCategoryDoc($id, $categoryId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
