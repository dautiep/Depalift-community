<?php

namespace Platform\CategoryEvents\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Eloquent;

class CategoryEventsRepository extends RepositoriesAbstract implements CategoryEventsInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_category_events.status', BaseStatusEnum::PUBLISHED)
            ->select('app_category_events.*')
            ->orderBy('app_category_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedCategories($limit, array $with = [])
    {
        $data = $this->model
            ->with(array_merge(['slugable'], $with))
            ->where([
                'app_category_events.status'      => BaseStatusEnum::PUBLISHED,
                'app_category_events.is_featured' => 1,
            ])
            ->select([
                'app_category_events.id',
                'app_category_events.name',
                'app_category_events.icon',
            ])
            ->orderBy('app_category_events.order', 'asc')
            ->select('app_category_events.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoriesEvents(array $condition = [], array $with = [])
    {
        $data = $this->model->with('slugable')->select('app_category_events.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('app_category_events.created_at', 'DESC')
            ->orderBy('app_category_events.order', 'DESC');

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryById($id)
    {
        $data = $this->model->with('slugable')->where([
            'app_category_events.id'     => $id,
            'app_category_events.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoriesEvents(array $select, array $orderBy)
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
    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['app_category_events.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('app_category_events.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryEventsWithChildren(array $condition = [], array $with = [], array $select = ['*'])
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
    public function getFilters($filters)
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
    public function getAllChildrenEvents($id, $with = [])
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['app_category_events.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $children = $model->children()->with($with)->select('*')->get();


        return $children;
    }

    public function getCategoryByPostEvents($id_post){
        $data = $this->model
            ->join('app_post_events_category', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
            ->where('app_post_events_category.post_events_id', '=', $id_post)
            ->select('app_category_events.*')
            ->with('slugable');
        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
