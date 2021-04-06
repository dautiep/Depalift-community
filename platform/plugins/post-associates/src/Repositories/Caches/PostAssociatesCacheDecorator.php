<?php

namespace Platform\PostAssociates\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;

class PostAssociatesCacheDecorator extends CacheAbstractDecorator implements PostAssociatesInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeatured_Associates(int $limit = 5, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostAssociatesNonInList(array $selected = [], $limit = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdAssociates($authorId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapAssociates()
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
    public function getRelatedAssociates($slug, $limit = 3)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRecentPostAssociates($limit = 5, $categoryId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchAssociates($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryAssociates($categoryId, $paginate = 12, $limit = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllPostAssociates($perPage = 12, $active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostAssociates($limit, array $args = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryAssociatesIds($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersAssociates(array $filters)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
