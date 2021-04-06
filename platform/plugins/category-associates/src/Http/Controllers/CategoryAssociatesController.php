<?php

namespace Platform\CategoryAssociates\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\CategoryAssociates\Http\Requests\CategoryAssociatesRequest;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Platform\CategoryAssociates\Tables\CategoryAssociatesTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\CategoryAssociates\Forms\CategoryAssociatesForm;
use Platform\Base\Forms\FormBuilder;
use Throwable;

class CategoryAssociatesController extends BaseController
{
    /**
     * @var CategoryAssociatesInterface
     */
    protected $categoryAssociatesRepository;

    /**
     * @param CategoryAssociatesInterface $categoryAssociatesRepository
     */
    public function __construct(CategoryAssociatesInterface $categoryAssociatesRepository)
    {
        $this->categoryAssociatesRepository = $categoryAssociatesRepository;
    }

    /**
     * @param CategoryAssociatesTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CategoryAssociatesTable $table)
    {
        page_title()->setTitle(trans('plugins/category-associates::category-associates.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/category-associates::category-associates.create'));

        return $formBuilder->create(CategoryAssociatesForm::class)->renderForm();
    }

    /**
     * @param CategoryAssociatesRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CategoryAssociatesRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->categoryAssociatesRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $categoryAssociates = $this->categoryAssociatesRepository->createOrUpdate(array_merge($request->input(), ['author_id' => Auth::user()->getKey(),]));

        event(new CreatedContentEvent(CATEGORY_ASSOCIATES_MODULE_SCREEN_NAME, $request, $categoryAssociates));

        return $response
            ->setPreviousUrl(route('category-associates.index'))
            ->setNextUrl(route('category-associates.edit', $categoryAssociates->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $categoryAssociates = $this->categoryAssociatesRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $categoryAssociates));

        page_title()->setTitle(trans('plugins/category-associates::category-associates.edit') . ' "' . $categoryAssociates->name . '"');

        return $formBuilder->create(CategoryAssociatesForm::class, ['model' => $categoryAssociates])->renderForm();
    }

    /**
     * @param $id
     * @param CategoryAssociatesRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CategoryAssociatesRequest $request, BaseHttpResponse $response)
    {
        $categoryAssociates = $this->categoryAssociatesRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->categoryAssociatesRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $categoryAssociates->fill($request->input());

        $this->categoryAssociatesRepository->createOrUpdate($categoryAssociates);

        event(new UpdatedContentEvent(CATEGORY_ASSOCIATES_MODULE_SCREEN_NAME, $request, $categoryAssociates));

        return $response
            ->setPreviousUrl(route('category-associates.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $categoryAssociates = $this->categoryAssociatesRepository->findOrFail($id);

            if(!$categoryAssociates->is_default){
                $this->categoryAssociatesRepository->delete($categoryAssociates);
                event(new DeletedContentEvent(CATEGORY_EVENTS_MODULE_SCREEN_NAME, $request, $categoryAssociates));
            }

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $categoryAssociates = $this->categoryAssociatesRepository->findOrFail($id);
            $this->categoryAssociatesRepository->delete($categoryAssociates);
            event(new DeletedContentEvent(CATEGORY_ASSOCIATES_MODULE_SCREEN_NAME, $request, $categoryAssociates));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
