<?php

namespace Platform\MemberOrganize\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\MemberOrganize\Repositories\Interfaces\MemberOrganizeInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\MemberOrganize\Models\MemberOrganize;
use Html;

class MemberOrganizeTable extends TableAbstract
{
    // protected $view = 'plugins/member-organize::table';

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * MemberOrganizeTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param MemberOrganizeInterface $memberOrganizeRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, MemberOrganizeInterface $memberOrganizeRepository)
    {
        $this->repository = $memberOrganizeRepository;
        $this->setOption('id', 'plugins-member-organize-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['member-organize.edit', 'member-organize.destroy'])) {
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
//            ->editColumn('name', function ($item) {
//                if (!Auth::user()->hasPermission('member-organize.edit')) {
//                    return $item->name;
//                }
//                return Html::link(route('member-organize.edit', $item->id), $item->name);
//            })
            ->editColumn('label', function($item) {
                return view('plugins/member-organize::partials.item-table', ['data' => $item]);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('member-organize.edit', 'member-organize.destroy', $item);
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
            'app_member_organizes.id',
            'app_member_organizes.name_vietnam',
            'app_member_organizes.name_english',
            'app_member_organizes.name_sub',
            'app_member_organizes.num_business',
            'app_member_organizes.issued_by',
            'app_member_organizes.date_at',
            'app_member_organizes.type_business',
            'app_member_organizes.pernament_main',
            'app_member_organizes.district_main',
            'app_member_organizes.address_main',
            'app_member_organizes.pernament_sub',
            'app_member_organizes.district_sub',
            'app_member_organizes.address_sub',
            'app_member_organizes.phone',
            'app_member_organizes.email',
            'app_member_organizes.link_web',
            'app_member_organizes.representative',
            'app_member_organizes.position',
            'app_member_organizes.name_member',
            'app_member_organizes.position_member',
            'app_member_organizes.phone_member',
            'app_member_organizes.career_main',
            'app_member_organizes.purpose',
            'app_member_organizes.file',
            'app_member_organizes.created_at',
            'app_member_organizes.status',
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
                'name'  => 'app_member_organizes.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'label' => [
                'name'  => 'app_member_organizes.name_vietnam',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'app_member_organizes.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-left',
            ],
//            'status' => [
//                'name'  => 'app_member_organizes.status',
//                'title' => trans('core/base::tables.status'),
//                'width' => '100px',
//                'class' => 'text-left',
//            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('member-organize.create'), 'member-organize.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, MemberOrganize::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('member-organize.deletes'), 'member-organize.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_member_organizes.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_member_organizes.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_member_organizes.created_at' => [
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
