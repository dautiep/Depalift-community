<?php

namespace Platform\PostProducer\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Eloquent;

interface PostProducerInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getFeaturedproducer(int $limit = 5, array $with = []);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListPostProducerNonInList(array $selected = [], $limit = 7);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserIdProducer($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMapProducer();

    // /**
    //  * @param int $tag
    //  * @param int $paginate
    //  * @return mixed
    //  */
    // public function getByTag($tag, $paginate = 12);

    /**
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelatedProducer($id, $limit = 3);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearchProducer($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllPostProducer($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularPostProducer($limit, array $args = []);
}
