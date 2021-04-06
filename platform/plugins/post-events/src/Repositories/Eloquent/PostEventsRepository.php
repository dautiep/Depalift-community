<?php

namespace Platform\PostEvents\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Eloquent;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class PostEventsRepository extends RepositoriesAbstract implements PostEventsInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeatured_events(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->where([
                'app_post_events.status'      => BaseStatusEnum::PUBLISHED,
                'app_post_events.is_featured' => 1,
            ])
            ->limit($limit)
            ->with(array_merge(['slugable'], $with))
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostEventsNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('app_post_events.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedEvents($id, $limit = 3)
    {
        $data = $this->model
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_events.id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryEvents($categoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
            ->join('app_category_events', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
            ->whereIn('app_post_events_category.category_events_id', $categoryId)
            ->select('app_post_events.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByCategoryEventsNoPerPage($categoryId, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
            ->join('app_category_events', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
            ->whereIn('app_post_events_category.category_events_id', $categoryId)
            ->select('app_post_events.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserId($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                'app_post_events.status'    => BaseStatusEnum::PUBLISHED,
                'app_post_events.author_id' => $authorId,
            ])
            ->with('slugable')
            ->select('app_post_events.*')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->select('app_post_events.*')
            ->orderBy('app_post_events.created_at', 'desc');

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
    public function getRecentPostEvents($limit = 5, $categoryId = 0)
    {
        $data = $this->model->where(['app_post_events.status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $data = $data->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
                ->where('app_post_events_category.category_events_id', $categoryId);
        }

        $data = $data->limit($limit)
            ->with('slugable')
            ->select('app_post_events.*')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        $data = $this->model->with('slugable')->where('app_post_events.status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('app_post_events.name', 'LIKE', '%' . $term . '%');
        }

        $data = $data->select('app_post_events.*')
            ->orderBy('app_post_events.created_at', 'desc');

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
    public function getAllPostEvents($perPage = 12, $active = true)
    {
        $data = $this->model->select('app_post_events.*')
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        if ($active) {
            $data = $data->where('app_post_events.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllPostEventsNoPerPage($limit = 12, $active = true)
    {
        $data = $this->model->select('app_post_events.*')
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        if ($active) {
            $data = $data->limit($limit);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostEvents($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('app_post_events.views', 'desc')
            ->select('app_post_events.*')
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedCategoryIds($model)
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
    public function getFilters(array $filters)
    {
        $this->model = $this->originalModel;

        if ($filters['categories'] !== null) {
            $categories = $filters['categories'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('app_category_events.id', $categories);
            });
        }

        if ($filters['categories_exclude'] !== null) {
            $excludeCategories = $filters['categories_exclude'];
            $this->model = $this->model->whereHas('categories', function ($query) use ($excludeCategories) {
                $query->whereNotIn('app_category_events.id', $excludeCategories);
            });
        }

        if ($filters['exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_events.id', $filters['exclude']);
        }

        if ($filters['include'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_events.id', $filters['include']);
        }

        if ($filters['author'] !== null) {
            $this->model = $this->model->whereIn('app_post_events.author_id', $filters['author']);
        }

        if ($filters['author_exclude'] !== null) {
            $this->model = $this->model->whereNotIn('app_post_events.author_id', $filters['author_exclude']);
        }

        if ($filters['featured'] !== null) {
            $this->model = $this->model->where('app_post_events.is_featured', $filters['featured']);
        }

        if ($filters['search'] !== null) {
            $this->model = $this->model->where('app_post_events.name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('app_post_events.content', 'like', '%' . $filters['search'] . '%');
        }

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'updated_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';

        $this->model->where('app_post_events.status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }

    public function getRelatedByCategoryEvents($id, $categoryId, $limit = 6)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('app_post_events.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_events.id', '!=', $id)
            ->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
            ->join('app_category_events', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
            ->whereIn('app_post_events_category.category_events_id', $categoryId)
            ->select('app_post_events.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedPostByCategoryEvents($categoryId, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where([
                'app_post_events.status'=> BaseStatusEnum::PUBLISHED,
                'app_post_events.is_featured' => 1,
            ])
            ->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
            ->join('app_category_events', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
            ->whereIn('app_post_events_category.category_events_id', $categoryId)
            ->select('app_post_events.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('app_post_events.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }
}
