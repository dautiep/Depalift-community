<?php

namespace Platform\CategoryTraining\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Eloquent;

class CategoryTrainingRepository extends RepositoriesAbstract implements CategoryTrainingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapCategoryTraining()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_category_training.status', BaseStatusEnum::PUBLISHED)
            ->select('app_category_training.*')
            ->orderBy('app_category_training.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedCategoryTraining($limit, array $with = [])
    {
        $data = $this->model
            ->with(array_merge(['slugable'], $with))
            ->where([
                'app_category_training.status'      => BaseStatusEnum::PUBLISHED,
                'app_category_training.is_featured' => 1,
            ])
            ->select([
                'app_category_training.id',
                'app_category_training.name',
                'app_category_training.icon',
            ])
            ->orderBy('app_category_training.order', 'asc')
            ->select('app_category_training.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllCategoryTraining(array $condition = [], array $with = [])
    {
        $data = $this->model->with('slugable')->select('app_category_training.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('app_category_training.created_at', 'DESC')
            ->orderBy('app_category_training.order', 'DESC');

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryTrainingById($id)
    {
        $data = $this->model->with('slugable')->where([
            'app_category_training.id'     => $id,
            'app_category_training.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoryTraining(array $select, array $orderBy)
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
    public function getAllRelatedChildrenIdsTraining($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['app_category_training.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('app_category_training.id')->get();

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
    public function getAllCategoryTrainingWithChildren(array $condition = [], array $with = [], array $select = ['*'])
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
    public function getFiltersTraining($filters)
    {
        $this->model = $this->originalModel;

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'created_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }

    public function getCategoryByPostTraining($id_post){
        $data = $this->model
            ->join('app_post_training_category', 'app_post_training_category.category_training_id', '=', 'app_category_training.id')
            ->where('app_post_training_category.post_training_id', '=', $id_post)
            ->select('app_category_training.*')
            ->with('slugable');
        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
