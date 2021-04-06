<?php

namespace Platform\PostTraining\Tables;

use Auth;
use BaseHelper;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Platform\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Platform\PostTraining\Models\PostTraining;
use Html;
use RvMedia;
use Carbon\Carbon;

class PostTrainingTable extends TableAbstract
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
     * @var CategoryTrainingInterface
     */
    protected $categoryTrainingRepository;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * PostTrainingTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PostTrainingInterface $postTrainingRepository
     * @param CategoryTrainingInterface $categoryTrainingRepository
     */
    public function __construct(
        DataTables $table, 
        UrlGenerator $urlGenerator, 
        PostTrainingInterface $postTrainingRepository,
        CategoryTrainingInterface $categoryTrainingRepository)
    {
        $this->repository = $postTrainingRepository;
        $this->setOption('id', 'plugins-post-training-table');
        $this->categoryTrainingRepository = $categoryTrainingRepository;
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['post-training.edit', 'post-training.destroy'])) {
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
                if (!Auth::user()->hasPermission('post-training.edit')) {
                    return $item->name;
                }
                return Html::link(route('post-training.edit', $item->id), $item->name);
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
                $categories_training = '';
                if ($item->categories_training) {
                    foreach ($item->categories_training as $category) {
                        $categories_training .= Html::link(route('category-training.edit', $category->id), $category->name) . ', ';
                    }
                    return rtrim($categories_training, ', ');
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
                return $this->getOperations('post-training.edit', 'post-training.destroy', $item);
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
            'app_post_trainings.id',
            'app_post_trainings.name',
            'app_post_trainings.image',
            'app_post_trainings.created_at',
            'app_post_trainings.status',
            'app_post_trainings.updated_at',
            'app_post_trainings.author_id',
            'app_post_trainings.author_type',
        ];

        $query = $model->with('categories_training', 'author')->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'app_post_trainings.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'posts.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name' => [
                'name'  => 'app_post_trainings.name',
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
                'name'  => 'app_post_trainings.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_post_trainings.status',
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
        $buttons = $this->addCreateButton(route('post-training.create'), 'post-training.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, PostTraining::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('post-training.deletes'), 'post-training.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_post_trainings.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_post_trainings.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'category'         => [
                'title'    => trans('plugins/blog::posts.category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategoryTraining',
            ],
            'app_post_trainings.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getCategoryTraining(): array
    {
        return $this->categoryRepository->pluck('app_category_training.name', 'app_category_training.id');
    }

    /**
     * {@inheritDoc}
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'app_post_trainings.created_at':
                if (!$value) {
                    break;
                }

                $value = Carbon::createFromFormat(config('core.base.general.date_format.date'), $value)->toDateString();

                return $query->whereDate($key, $operator, $value);
            case 'category':
                if (!$value) {
                    break;
                }

                return $query->join('app_post_training_category', 'app_post_training_category.post_training_id', '=', 'app_post_training.id')
                    ->join('app_category_training', 'app_post_training_category.category_training_id', '=', 'app_category_training.id')
                    ->where('app_post_training_category.category_training_id', $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->category_training()->sync([$inputValue]);
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
