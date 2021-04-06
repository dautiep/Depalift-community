<?php

namespace Platform\CategoryAssociates\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;

class CategoryAssociatesCacheDecorator extends CacheAbstractDecorator implements CategoryAssociatesInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapCategoryAssociates()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedCategoryAssociates($limit, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryAssociates(array $condition = [], array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryAssociatesById($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryAssociates(array $select, array $orderBy)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllRelatedChildrenIdsAssociates($id)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryAssociatesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersAssociates($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllChildrenAssociate($model, $with)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
