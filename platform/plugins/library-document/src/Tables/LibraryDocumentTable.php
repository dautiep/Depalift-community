<?php

namespace Platform\LibraryDocument\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\LibraryDocument\Models\LibraryDocument;
use Html;

class LibraryDocumentTable extends TableAbstract
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
     * LibraryDocumentTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param LibraryDocumentInterface $libraryDocumentRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, LibraryDocumentInterface $libraryDocumentRepository)
    {
        $this->repository = $libraryDocumentRepository;
        $this->setOption('id', 'plugins-library-document-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['library-document.edit', 'library-document.destroy'])) {
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
                if (!Auth::user()->hasPermission('library-document.edit')) {
                    return $item->name;
                }
                return Html::link(route('library-document.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('updated_at', function ($item) {
                return $item->category->name;
                // return Html::link(route('library-category.edit', $item->category->id), $item->category->name);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('library-document.edit', 'library-document.destroy', $item);
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
            'app_library_documents.id',
            'app_library_documents.name',
            'app_library_documents.library_category_id',
            'app_library_documents.description',
            'app_library_documents.created_at',
            'app_library_documents.updated_at',
            'app_library_documents.status',
        ];

        $query = $model
            ->with([
                'category' => function ($query){
                    $query->select(['app_library_categories.id', 'app_library_categories.name']);
                },
            ])
            ->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_library_documents.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'app_library_documents.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
			'description' => [
				'name'  => 'app_library_documents.description',
				'title' => trans('Mô tả'),
				'class' => 'text-left',
			],
            'created_at' => [
                'name'  => 'app_library_documents.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'updated_at' => [
                'name'      => 'app_library_documents.updated_at',
                'title'     => 'Danh mục',
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'status' => [
                'name'  => 'app_library_documents.status',
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
        $buttons = $this->addCreateButton(route('library-document.create'), 'library-document.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, LibraryDocument::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('library-document.deletes'), 'library-document.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_library_documents.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_library_documents.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_library_documents.created_at' => [
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
