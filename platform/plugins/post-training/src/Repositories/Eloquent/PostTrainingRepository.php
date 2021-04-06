<?php

namespace Platform\PostTraining\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Eloquent;
use Exception;
use Illuminate\Support\Arr;

class PostTrainingRepository extends RepositoriesAbstract implements PostTrainingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeatured_training(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->where([
                'app_post_trainings.status'      => BaseStatusEnum::PUBLISHED,
                'app_post_trainings.is_featured' => 1,
            ])
            ->limit($limit)
            ->with(array_merge(['slugable'], $with))
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostTrainingNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('app_post_trainings.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedTraining($id, $limit = 3)
    {
        $data = $this->model
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_trainings.id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryTraining($categoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->join('app_post_training_category', 'app_post_training_category.post_training_id', '=', 'app_post_trainings.id')
            ->join('app_category_training', 'app_post_training_category.category_training_id', '=', 'app_category_training.id')
            ->whereIn('app_post_training_category.category_training_id', $categoryId)
            ->select('app_post_trainings.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_trainings.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdTraining($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                'app_post_trainings.status'    => BaseStatusEnum::PUBLISHED,
                'app_post_trainings.author_id' => $authorId,
            ])
            ->with('slugable')
            ->select('app_post_trainings.*')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapTraining()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->select('app_post_trainings.*')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    // /**
    //  * {@inheritDoc}
    //  */
    // public function getByTag($tag, $paginate = 12)
    // {
    //     $data = $this->model
    //         ->with('slugable')
    //         ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
    //         ->whereHas('tags', function ($query) use ($tag) {
    //             /**
    //              * @var Builder $query
    //              */
    //             $query->where('tags.id', $tag);
    //         })
    //         ->select('app_post_events.*')
    //         ->orderBy('app_post_events.created_at', 'desc');

    //     return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    // }

    /**
     * {@inheritDoc}
     */
    public function getRecentPostTraining($limit = 5, $categoryId = 0)
    {
        $data = $this->model->where(['app_post_trainings.status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $data = $data->join('app_post_training_category', 'app_post_training_category.post_training_id', '=', 'app_post_trainings.id')
                ->where('app_post_training_category.category_training_id', $categoryId);
        }

        $data = $data->limit($limit)
            ->with('slugable')
            ->select('app_post_trainings.*')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchTraining($query, $limit = 10, $paginate = 10)
    {
        $data = $this->model->with('slugable')->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('app_post_trainings.name', 'LIKE', '%' . $term . '%');
        }

        $data = $data->select('app_post_trainings.*')
            ->orderBy('app_post_trainings.created_at', 'desc');

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllPostTraining($perPage = 12, $active = true)
    {
        $data = $this->model->select('app_post_trainings.*')
            ->with('slugable')
            ->orderBy('app_post_trainings.created_at', 'desc');

        if ($active) {
            $data = $data->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostTraining($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('app_post_trainings.views', 'desc')
            ->select('app_post_trainings.*')
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryIdsTraining($model)
    {
        $model = $model instanceof Eloquent ? $model : $this->findOrFail($model);

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getFiltersTraining(array $filters)
    {
        $this->model = $this->originalModel;

        if ($filters['categories'] !== null) {
            $categories = $filters['categories'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('app_category_training.id', $categories);
            });
        }

        if ($filters['categories_exclude'] !== null) {
            $excludeCategories = $filters['categories_exclude'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($excludeCategories) {
                $query->whereNotIn('app_category_training.id', $excludeCategories);
            });
        }

        if ($filters['exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_trainings.id', $filters['exclude']);
        }

        if ($filters['include'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_trainings.id', $filters['include']);
        }

        if ($filters['author'] !== null) {
            $this->model = $this->model->whereIn('app_post_trainings.author_id', $filters['author']);
        }

        if ($filters['author_exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_trainings.author_id', $filters['author_exclude']);
        }

        if ($filters['featured'] !== null) {
            $this->model = $this->model->where('app_post_trainings.is_featured', $filters['featured']);
        }

        if ($filters['search'] !== null) {
            $this->model = $this->model->where('app_post_trainings.name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('app_post_trainings.content', 'like', '%' . $filters['search'] . '%');
        }

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'updated_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';

        $this->model->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }

    public function getRelatedByCategoryTraining($id, $categoryId, $limit = 6)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_trainings.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_trainings.id', '!=', $id)
            ->join('app_post_training_category', 'app_post_training_category.post_training_id', '=', 'app_post_trainings.id')
            ->join('app_category_training', 'app_post_training_category.category_training_id', '=', 'app_category_training.id')
            ->whereIn('app_post_training_category.category_training_id', $categoryId)
            ->select('app_post_trainings.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_trainings.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }
}
