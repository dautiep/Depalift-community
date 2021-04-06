<?php

namespace Platform\PostProducer\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\PostProducer\Models\PostProducer;
use Html;
use RvMedia;
use Carbon\Carbon;

class PostProducerTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * PostProducerTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostProducerInterface $postProducerRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PostProducerInterface $postProducerRepository)
    {
        $this->repository = $postProducerRepository;
        $this->setOption('id', 'plugins-post-producer-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['post-producer.edit', 'post-producer.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('post-producer.edit')) {
                    return $item->name;
                }
                return Html::link(route('post-producer.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                if ($this->request()->input('action') == 'csv') {
                    return RvMedia::getImageUrl($item->image, null, false, RvMedia::getDefaultImage());
                }

                if ($this->request()->input('action') == 'excel') {
                    return RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage());
                }

                return Html::image(
                    RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()),
                    $item->name,
                    ['width' => 50]
                );
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('author_id', function ($item) {
                return $item->author ? $item->author->getFullName() : null;
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });


        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('post-producer.edit', 'post-producer.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'app_post_producers.id',
            'app_post_producers.name',
            'app_post_producers.image',
            'app_post_producers.created_at',
            'app_post_producers.status',
            'app_post_producers.author_id',
            'app_post_producers.author_type',
        ];

        $query = $model->with('author')->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_post_producers.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'app_post_producers.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name' => [
                'name'  => 'app_post_producers.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'author_id'  => [
                'name'      => 'app_post_producers.author_id',
                'title'     => trans('plugins/blog::posts.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'app_post_producers.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_post_producers.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('post-producer.create'), 'post-producer.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, PostProducer::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('post-producer.deletes'), 'post-producer.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_post_producers.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_post_producers.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_post_producers.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
