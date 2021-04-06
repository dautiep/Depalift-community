<?php

namespace Platform\CategoryEvents\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface CategoryEventsInterface extends RepositoryInterface
{
    /**
     * @return array
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @param array $with
     */
    public function getFeaturedCategories($limit, array $with = []);

    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    public function getAllCategoriesEvents(array $condition = [], array $with = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategoryById($id);

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategoriesEvents(array $select, array $orderBy);

    /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCategoryEventsWithChildren(array $condition = [], array $with = [], array $select = ['*']);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFilters($filters);

     /**
     *@param int $id_post
     * @return mixed
     */
    public function getCategoryByPostEvents($id_post);
}
