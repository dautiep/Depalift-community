<?php

namespace Platform\PostEvents\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Eloquent;

interface PostEventsInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getFeatured_events(int $limit = 5, array $with = []);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFilters(array $filters);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListPostEventsNonInList(array $selected = [], $limit = 7);

    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByCategoryEvents($categoryId, $paginate = 12, $limit = 0);

    /**
     * @param int|array $categoryId
     * @param int $limit
     * @return mixed
     */
    public function getByCategoryEventsNoPerPage($categoryId, $limit = 0);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserId($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMap();

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
    public function getRelatedEvents($id, $limit = 3);

    /**
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getRecentPostEvents($limit = 5, $categoryId = 0);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearch($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllPostEvents($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularPostEvents($limit, array $args = []);

    /**
     * @param Eloquent|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model);

    /**
     * @param int $categoryId
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelatedByCategoryEvents($id, $categoryId, $limit = 6);

    /**
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getRelatedPostByCategoryEvents($categoryId, $limit = 5);

    /**
     *@param int $limit
     * @param bool $active
     * @return mixed
     */
    public function getAllPostEventsNoPerPage($limit = 12, $active = true);
}
