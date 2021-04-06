<?php

namespace Platform\MemberPersonal\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\MemberPersonal\Repositories\Interfaces\MemberPersonalInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\MemberPersonal\Models\MemberPersonal;
use Html;

class MemberPersonalTable extends TableAbstract
{
//    protected $view = 'plugins/member-personal::table';

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * MemberPersonalTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param MemberPersonalInterface $memberPersonalRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, MemberPersonalInterface $memberPersonalRepository)
    {
        $this->repository = $memberPersonalRepository;
        $this->setOption('id', 'plugins-member-personal-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['member-personal.edit', 'member-personal.destroy'])) {
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
//                if (!Auth::user()->hasPermission('member-personal.edit')) {
//                    return $item->name;
//                }
//                return Html::link(route('member-personal.edit', $item->id), $item->name);
//            })
            ->editColumn('label', function($item) {
                return view('plugins/member-personal::partials.item-table', ['data' => $item]);
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
                return $this->getOperations('member-personal.edit', 'member-personal.destroy', $item);
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
            'app_member_personals.id',
            'app_member_personals.name',
            'app_member_personals.sex',
            'app_member_personals.birth_day',
            'app_member_personals.place_birth',
            'app_member_personals.country',
            'app_member_personals.religion',
            'app_member_personals.identify',
            'app_member_personals.date_range',
            'app_member_personals.issued_by',
            'app_member_personals.pernament_main',
            'app_member_personals.district_main',
            'app_member_personals.address_main',
            'app_member_personals.pernament_sub',
            'app_member_personals.district_sub',
            'app_member_personals.address_sub',
            'app_member_personals.mail',
            'app_member_personals.num_phone',
            'app_member_personals.link_fb',
            'app_member_personals.education',
            'app_member_personals.works',
            'app_member_personals.work_place',
            'app_member_personals.position',
            'app_member_personals.address_work',
            'app_member_personals.degree',
            'app_member_personals.capacity',
            'app_member_personals.purpose',
            'app_member_personals.created_at',
            'app_member_personals.status',
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
                'name'  => 'app_member_personals.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
                'class' => 'text-left',
            ],
            'label' => [
                'name'  => 'app_member_personals.name',
                'title' => 'THÔNG TIN HỘI VIÊN',
                'class' => 'text-center',
            ],
            'created_at' => [
                'name'  => 'app_member_personals.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '70px',
                'class' => 'text-left',
            ],
//            'status' => [
//                'name'  => 'app_member_personals.status',
//                'title' => trans('core/base::tables.status'),
//                'width' => '50px',
//                'class' => 'text-left',
//            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('member-personal.create'), 'member-personal.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, MemberPersonal::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('member-personal.deletes'), 'member-personal.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_member_personals.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_member_personals.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_member_personals.created_at' => [
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
