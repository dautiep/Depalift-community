<?php

namespace Platform\PostAssociates\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\PostAssociates\Models\PostAssociates;
use Html;
use RvMedia;
use Carbon\Carbon;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;

class PostAssociatesTable extends TableAbstract
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
     * @var CategoryAssociatesInterface
     */
    protected $categoryAssociatesRepository;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * PostAssociatesTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostAssociatesInterface $postAssociatesRepository
     * @param CategoryAssociatesInterface $categoryAssociatesRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        PostAssociatesInterface $postAssociatesRepository,
        CategoryAssociatesInterface $categoryAssociatesRepository
    ) {
        $this->repository = $postAssociatesRepository;
        $this->setOption('id', 'plugins-post-associates-table');
        $this->categoryAssociatesRepository = $categoryAssociatesRepository;
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['post-associates.edit', 'post-associates.destroy'])) {
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
                if (!Auth::user()->hasPermission('post-associates.edit')) {
                    return $item->name;
                }
                return Html::link(route('post-associates.edit', $item->id), $item->name);
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
                $categories_associates = '';
                foreach ($item->categories_associates as $category) {
                    $categories_associates .= Html::link(route('category-associates.edit', $category->id), $category->name) . ', ';
                }
                return rtrim($categories_associates, ', ');
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
                return $this->getOperations('post-associates.edit', 'post-associates.destroy', $item);
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
            'app_post_associates.id',
            'app_post_associates.name',
            'app_post_associates.image',
            'app_post_associates.created_at',
            'app_post_associates.status',
            'app_post_associates.updated_at',
            'app_post_associates.author_id',
            'app_post_associates.author_type',
        ];

        $query = $model->with('categories_associates', 'author')->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_post_associates.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'posts.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name' => [
                'name'  => 'app_post_associates.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'updated_at' => [
                'name'      => 'posts.updated_at',
                'title'     => trans('plugins/blog::posts.categories'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'author_id'  => [
                'name'      => 'posts.author_id',
                'title'     => trans('plugins/blog::posts.author'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'app_post_associates.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_post_associates.status',
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
        $buttons = $this->addCreateButton(route('post-associates.create'), 'post-associates.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, PostAssociates::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('post-associates.deletes'), 'post-associates.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_post_associates.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_post_associates.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'category'         => [
                'title'    => trans('plugins/blog::posts.category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategoryAssociates',
            ],
            'app_post_associates.created_at' => [
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

    /**
     * @return array
     */
    public function getCategoryAssociates(): array
    {
        return $this->categoryRepository->pluck('app_category_associates.name', 'app_category_associates.id');
    }

    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'app_post_associates.created_at':
                if (!$value) {
                    break;
                }

                $value = Carbon::createFromFormat(config('core.base.general.date_format.date'), $value)->toDateString();

                return $query->whereDate($key, $operator, $value);
            case 'category':
                if (!$value) {
                    break;
                }

                return $query->join('app_post_associates_category', 'app_post_associates_category.post_associates_id', '=', 'app_post_associates.id')
                    ->join('app_category_associates', 'app_post_associates_category.category_associates_id', '=', 'app_category_associates.id')
                    ->where('app_post_associates_category.category_associates_id', $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->category_associates()->sync([$inputValue]);
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
