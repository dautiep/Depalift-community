<?php

namespace Platform\PostAssociates\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Eloquent;
use Exception;
use Illuminate\Support\Arr;

class PostAssociatesRepository extends RepositoriesAbstract implements PostAssociatesInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeatured_Associates(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->where([
                'app_post_associates.status'      => BaseStatusEnum::PUBLISHED,
                'app_post_associates.is_featured' => 1,
            ])
            ->limit($limit)
            ->with(array_merge(['slugable'], $with))
            ->orderBy('app_post_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostAssociatesNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('app_post_associates.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedAssociates($id, $limit = 3)
    {
        $data = $this->model
            ->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_associates', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryAssociates($categoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)
            ->join('app_post_associates_category', 'app_post_associates_category.post_associates_id', '=', 'app_post_associates.id')
            ->join('app_category_associates', 'app_post_associates_category.category_associates_id', '=', 'app_category_associates.id')
            ->whereIn('app_post_associates_category.category_associates_id', $categoryId)
            ->select('app_post_associates.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_associates.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdAssociates($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                'app_post_associates.status'    => BaseStatusEnum::PUBLISHED,
                'app_post_associates.author_id' => $authorId,
            ])
            ->with('slugable')
            ->select('app_post_associates.*')
            ->orderBy('app_post_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapAssociates()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)
            ->select('app_post_associates.*')
            ->orderBy('app_post_associates.created_at', 'desc');

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
    public function getRecentPostAssociates($limit = 5, $categoryId = 0)
    {
        $data = $this->model->where(['app_post_associates.status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $data = $data->join('app_post_associates_category', 'app_post_associates_category.post_associates_id', '=', 'app_post_associates.id')
                ->where('app_post_associates_category.category_associates_id', $categoryId);
        }

        $data = $data->limit($limit)
            ->with('slugable')
            ->select('app_post_associates.*')
            ->orderBy('app_post_associates.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchAssociates($query, $limit = 10, $paginate = 10)
    {
        $data = $this->model->with('slugable')->where('app_post_associates.status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('app_post_associates.name', 'LIKE', '%' . $term . '%');
        }

        $data = $data->select('app_post_associates.*')
            ->orderBy('app_post_associates.created_at', 'desc');

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
    public function getAllPostAssociates($perPage = 12, $active = true)
    {
        $data = $this->model->select('app_post_associates.*')
            ->with('slugable')
            ->orderBy('app_post_associates.created_at', 'desc');

        if ($active) {
            $data = $data->where('app_post_associates.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostAssociates($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('app_post_associates.views', 'desc')
            ->select('app_post_associates.*')
            ->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryAssociatesIds($model)
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
    public function getFiltersAssociates(array $filters)
    {
        $this->model = $this->originalModel;

        if ($filters['categories'] !== null) {
            $categories = $filters['categories'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('app_category_associates.id', $categories);
            });
        }

        if ($filters['categories_exclude'] !== null) {
            $excludeCategories = $filters['categories_exclude'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($excludeCategories) {
                $query->whereNotIn('app_category_associates.id', $excludeCategories);
            });
        }

        if ($filters['exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_associates.id', $filters['exclude']);
        }

        if ($filters['include'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_associates.id', $filters['include']);
        }

        if ($filters['author'] !== null) {
            $this->model = $this->model->whereIn('app_post_associates.author_id', $filters['author']);
        }

        if ($filters['author_exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_associates.author_id', $filters['author_exclude']);
        }

        if ($filters['featured'] !== null) {
            $this->model = $this->model->where('app_post_associates.is_featured', $filters['featured']);
        }

        if ($filters['search'] !== null) {
            $this->model = $this->model->where('app_post_associates.name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('app_post_associates.content', 'like', '%' . $filters['search'] . '%');
        }

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'updated_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';

        $this->model->where('app_post_associates.status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }
}
