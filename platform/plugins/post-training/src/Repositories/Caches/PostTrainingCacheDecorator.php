<?php

namespace Platform\PostTraining\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;

class PostTrainingCacheDecorator extends CacheAbstractDecorator implements PostTrainingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeatured_training(int $limit = 5, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostTrainingNonInList(array $selected = [], $limit = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdTraining($authorId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapTraining()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    // /**
    //  * {@inheritDoc}
    //  */
    // public function getByTag($tag, $paginate = 12)
    // {
    //     return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    // }

    /**
     * {@inheritDoc}
     */
    public function getRelatedTraining($slug, $limit = 3)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRecentPostTraining($limit = 5, $categoryId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchTraining($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryTraining($categoryId, $paginate = 12, $limit = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllPostTraining($perPage = 12, $active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostTraining($limit, array $args = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryIdsTraining($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersTraining(array $filters)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedByCategoryTraining($id , $categoryId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
