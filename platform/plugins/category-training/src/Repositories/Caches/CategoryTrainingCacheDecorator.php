<?php

namespace Platform\CategoryTraining\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;

class CategoryTrainingCacheDecorator extends CacheAbstractDecorator implements CategoryTrainingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapCategoryTraining()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedCategoryTraining($limit, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryTraining(array $condition = [], array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryTrainingById($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryTraining(array $select, array $orderBy)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllRelatedChildrenIdsTraining($id)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryTrainingWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersTraining($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryByPostTraining($id_post)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
