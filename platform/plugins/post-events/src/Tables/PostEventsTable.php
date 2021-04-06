<?php

namespace Platform\PostEvents\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Platform\PostEvents\Models\PostEvents;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Html;
use RvMedia;

class PostEventsTable extends TableAbstract
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
     * @var CategoryEventsInterface
     */
    protected $categoryEventsRepository;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * PostEventsTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostEventsInterface $postEventsRepository
     * @param CategoryEventsInterface $categoryEventsRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        PostEventsInterface $postEventsRepository,
        CategoryEventsInterface $categoryEventsRepository
    ) {
        $this->repository = $postEventsRepository;
        $this->setOption('id', 'plugins-post-events-table');
        $this->categoryEventsRepository = $categoryEventsRepository;
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['post-events.edit', 'post-events.destroy'])) {
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
                if (!Auth::user()->hasPermission('post-events.edit')) {
                    return $item->name;
                }
                return Html::link(route('post-events.edit', $item->id), $item->name);
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
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('updated_at', function ($item) {
                $categories_events = '';
                if ($item->categories_events) {
                    foreach ($item->categories_events as $category) {
                        $categories_events .= Html::link(route('category-events.edit', $category->id), $category->name) . ', ';
                    }
                    return rtrim($categories_events, ', ');
                }
            })
            ->editColumn('author_id', function ($item) {
                return $item->author ? $item->author->getFullName() : null;
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('post-events.edit', 'post-events.destroy', $item);
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
            'app_post_events.id',
            'app_post_events.name',
            'app_post_events.image',
            'app_post_events.created_at',
            'app_post_events.status',
            'app_post_events.updated_at',
            'app_post_events.author_id',
            'app_post_events.author_type',
        ];

        $query = $model->with('categories_events', 'author')->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_post_events.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'app_post_events.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name' => [
                'name'  => 'app_post_events.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'updated_at' => [
                'name'      => 'app_post_events.updated_at',
                'title'     => trans('plugins/blog::posts.categories'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'author_id'  => [
                'name'      => 'app_post_events.author_id',
                'title'     => trans('plugins/blog::posts.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'app_post_events.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_post_events.status',
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
        $buttons = $this->addCreateButton(route('post-events.create'), 'post-events.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, PostEvents::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('post-events.deletes'), 'post-events.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_post_events.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_post_events.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'category'         => [
                'title'    => trans('plugins/blog::posts.category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategoryEvents',
            ],
            'app_post_events.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getCategoryEvents(): array
    {
        return $this->categoryRepository->pluck('app_category_events.name', 'app_category_events.id');
    }

    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'app_post_events.created_at':
                if (!$value) {
                    break;
                }

                $value = Carbon::createFromFormat(config('core.base.general.date_format.date'), $value)->toDateString();

                return $query->whereDate($key, $operator, $value);
            case 'category':
                if (!$value) {
                    break;
                }

                return $query->join('app_post_events_category', 'app_post_events_category.post_events_id', '=', 'app_post_events.id')
                    ->join('app_category_events', 'app_post_events_category.category_events_id', '=', 'app_category_events.id')
                    ->where('app_post_events_category.category_events_id', $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->category_events()->sync([$inputValue]);
            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
