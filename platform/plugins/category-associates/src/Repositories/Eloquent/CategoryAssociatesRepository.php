<?php

namespace Platform\CategoryAssociates\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Eloquent;

class CategoryAssociatesRepository extends RepositoriesAbstract implements CategoryAssociatesInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapCategoryAssociates()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_category_associates.status', BaseStatusEnum::PUBLISHED)
            ->select('app_category_associates.*')
            ->orderBy('app_category_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedCategoryAssociates($limit, array $with = [])
    {
        $data = $this->model
            ->with(array_merge(['slugable'], $with))
            ->where([
                'app_category_associates.status'      => BaseStatusEnum::PUBLISHED,
                'app_category_associates.is_featured' => 1,
            ])
            ->select([
                'app_category_associates.id',
                'app_category_associates.name',
                'app_category_associates.icon',
            ])
            ->orderBy('app_category_associates.order', 'asc')
            ->select('app_category_associates.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryAssociates(array $condition = [], array $with = [])
    {
        $data = $this->model->with('slugable')->select('app_category_associates.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('app_category_associates.created_at', 'DESC')
            ->orderBy('app_category_associates.order', 'DESC');

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryAssociatesById($id)
    {
        $data = $this->model->with('slugable')->where([
            'app_category_associates.id'     => $id,
            'app_category_associates.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryAssociates(array $select, array $orderBy)
    {
        $data = $this->model->with('slugable')->select($select);
        foreach ($orderBy as $by => $direction) {
            $data = $data->orderBy($by, $direction);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllRelatedChildrenIdsAssociates($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['app_category_associates.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('app_category_associates.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIdsAssociates($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryAssociatesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersAssociates($filters)
    {
        $this->model = $this->originalModel;

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'created_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllChildrenAssociate($id, $with = [])
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['app_category_associates.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $children = $model->children()->with($with)->select('*')->get();


        return $children;
    }
}
