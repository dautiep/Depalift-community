<?php

namespace Platform\CategoryAssociates\Repositories\Interfaces;

use Platform\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface CategoryAssociatesInterface extends RepositoryInterface
{
    /**
     * @return array
     */
    public function getDataSiteMapCategoryAssociates();

    /**
     * @param int $limit
     * @param array $with
     */
    public function getFeaturedCategoryAssociates($limit, array $with = []);

    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    public function getAllCategoryAssociates(array $condition = [], array $with = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategoryAssociatesById($id);

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategoryAssociates(array $select, array $orderBy);

    /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIdsAssociates($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCategoryAssociatesWithChildren(array $condition = [], array $with = [], array $select = ['*']);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFiltersAssociates($filters);
}
