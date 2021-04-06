<?php

namespace Platform\CategoryEvents\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\CategoryEvents\Models\CategoryEvents;
use Html;

class CategoryEventsTable extends TableAbstract
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
     * CategoryEventsTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param CategoryEventsInterface $categoryEventsRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, CategoryEventsInterface $categoryEventsRepository)
    {
        $this->repository = $categoryEventsRepository;
        $this->setOption('id', 'plugins-category-events-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['category-events.edit', 'category-events.destroy'])) {
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
                if (!Auth::user()->hasPermission('category-events.edit')) {
                    return $item->name;
                }
                return Html::link(route('category-events.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('updated_at', function ($item) {
                return BaseHelper::formatDate($item->updated_at);
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            })
            ->removeColumn('is_default');

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('category-events.edit', 'category-events.destroy', $item);
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
            'app_category_events.id',
            'app_category_events.name',
            'app_category_events.created_at',
            'app_category_events.updated_at',
            'app_category_events.status',
        ];

        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_category_events.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'app_category_events.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'app_category_events.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'updated_at' => [
                'name'  => 'app_category_events.updated_at',
                'title' => trans('core/base::tables.updated_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_category_events.status',
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
        $buttons = $this->addCreateButton(route('category-events.create'), 'category-events.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, CategoryEvents::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('category-events.deletes'), 'category-events.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_category_events.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_category_events.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_category_events.created_at' => [
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
