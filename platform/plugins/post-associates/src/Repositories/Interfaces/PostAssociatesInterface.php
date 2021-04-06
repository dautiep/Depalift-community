<?php

namespace Platform\PostAssociates\Repositories\Interfaces;
use Eloquent;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;

interface PostAssociatesInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getFeatured_Associates(int $limit = 5, array $with = []);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFiltersAssociates(array $filters);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListPostAssociatesNonInList(array $selected = [], $limit = 7);

    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByCategoryAssociates($categoryId, $paginate = 12, $limit = 0);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserIdAssociates($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMapAssociates();

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
    public function getRelatedAssociates($id, $limit = 3);

    /**
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getRecentPostAssociates($limit = 5, $categoryId = 0);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearchAssociates($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllPostAssociates($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularPostAssociates($limit, array $args = []);

    /**
     * @param Eloquent|int $model
     * @return array
     */
    public function getRelatedCategoryAssociatesIds($model);
}
