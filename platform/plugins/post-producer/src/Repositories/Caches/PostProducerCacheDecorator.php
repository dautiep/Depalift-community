<?php

namespace Platform\PostProducer\Repositories\Caches;

use Platform\Support\Repositories\Caches\CacheAbstractDecorator;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;

class PostProducerCacheDecorator extends CacheAbstractDecorator implements PostProducerInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeaturedproducer(int $limit = 5, array $with = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostProducerNonInList(array $selected = [], $limit = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdProducer($authorId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapProducer()
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
    public function getRelatedProducer($slug, $limit = 3)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchProducer($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllPostProducer($perPage = 12, $active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostProducer($limit, array $args = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryIdsProducer($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
