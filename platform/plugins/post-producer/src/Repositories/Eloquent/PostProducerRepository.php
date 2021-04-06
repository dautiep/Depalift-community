<?php

namespace Platform\PostProducer\Repositories\Eloquent;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Repositories\Eloquent\RepositoriesAbstract;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;
use Eloquent;
use Exception;
use Illuminate\Support\Arr;

class PostProducerRepository extends RepositoriesAbstract implements PostProducerInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFeaturedproducer(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->where([
                'app_post_producers.status'      => BaseStatusEnum::PUBLISHED,
                'app_post_producers.is_featured' => 1,
            ])
            ->limit($limit)
            ->with(array_merge(['slugable'], $with))
            ->orderBy('app_post_producers.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getListPostProducerNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('app_post_producers.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('app_post_producers.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_producers.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedProducer($id, $limit = 3)
    {
        $data = $this->model
            ->where('app_post_producers.status', BaseStatusEnum::PUBLISHED)
            ->where('app_post_producers.id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('app_post_producers.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdProducer($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                'app_post_producers.status'    => BaseStatusEnum::PUBLISHED,
                'app_post_producers.author_id' => $authorId,
            ])
            ->with('slugable')
            ->select('app_post_producers.*')
            ->orderBy('app_post_producers.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMapProducer()
    {
        $data = $this->model
            ->with('slugable')
            ->where('app_post_producers.status', BaseStatusEnum::PUBLISHED)
            ->select('app_post_producers.*')
            ->orderBy('app_post_producers.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchProducer($query, $limit = 10, $paginate = 10)
    {
        $data = $this->model->with('slugable')->where('app_post_producers.status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $data = $data->where('app_post_producers.name', 'LIKE', '%' . $term . '%');
        }

        $data = $data->select('app_post_producers.*')
            ->orderBy('app_post_producers.created_at', 'desc');

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
    public function getAllPostProducer($perPage = 12, $active = true)
    {
        $data = $this->model->select('app_post_producers.*')
            ->with('slugable')
            ->orderBy('app_post_producers.created_at', 'desc');

        if ($active) {
            $data = $data->where('app_post_producers.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularPostProducer($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('app_post_producers.views', 'desc')
            ->select('app_post_producers.*')
            ->where('app_post_producers.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
