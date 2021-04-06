<?php

namespace Platform\PostTraining\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Eloquent;

interface PostTrainingInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @param array $with
     * @return mixed
     */
    public function getFeatured_training(int $limit = 5, array $with = []);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFiltersTraining(array $filters);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListPostTrainingNonInList(array $selected = [], $limit = 7);

    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByCategoryTraining($categoryId, $paginate = 12, $limit = 0);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserIdTraining($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMapTraining();

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
    public function getRelatedTraining($id, $limit = 3);

    /**
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getRecentPostTraining($limit = 5, $categoryId = 0);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearchTraining($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllPostTraining($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularPostTraining($limit, array $args = []);

    /**
     * @param Eloquent|int $model
     * @return array
     */
    public function getRelatedCategoryIdsTraining($model);

    /**
     * @param int $categoryId
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelatedByCategoryTraining($id, $categoryId, $limit = 6);
}
