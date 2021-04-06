<?php

namespace Platform\CategoryTraining\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface CategoryTrainingInterface extends RepositoryInterface
{
    /**
     * @return array
     */
    public function getDataSiteMapCategoryTraining();

    /**
     * @param int $limit
     * @param array $with
     */
    public function getFeaturedCategoryTraining($limit, array $with = []);

    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    public function getAllCategoryTraining(array $condition = [], array $with = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategoryTrainingById($id);

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategoryTraining(array $select, array $orderBy);

    /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIdsTraining($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCategoryTrainingWithChildren(array $condition = [], array $with = [], array $select = ['*']);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFiltersTraining($filters);

     /**
     *@param int $id_post
     * @return mixed
     */
    public function getCategoryByPostTraining($id_post);
}
