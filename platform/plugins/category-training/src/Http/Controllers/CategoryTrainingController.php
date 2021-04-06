<?php

namespace Platform\CategoryTraining\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\CategoryTraining\Http\Requests\CategoryTrainingRequest;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Platform\CategoryTraining\Tables\CategoryTrainingTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\CategoryTraining\Forms\CategoryTrainingForm;
use Platform\Base\Forms\FormBuilder;
use Throwable;

class CategoryTrainingController extends BaseController
{
    /**
     * @var CategoryTrainingInterface
     */
    protected $categoryTrainingRepository;

    /**
     * @param CategoryTrainingInterface $categoryTrainingRepository
     */
    public function __construct(CategoryTrainingInterface $categoryTrainingRepository)
    {
        $this->categoryTrainingRepository = $categoryTrainingRepository;
    }

    /**
     * @param CategoryTrainingTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CategoryTrainingTable $table)
    {
        page_title()->setTitle(trans('plugins/category-training::category-training.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/category-training::category-training.create'));

        return $formBuilder->create(CategoryTrainingForm::class)->renderForm();
    }

    /**
     * @param CategoryTrainingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CategoryTrainingRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->categoryTrainingRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $categoryTraining = $this->categoryTrainingRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(CATEGORY_TRAINING_MODULE_SCREEN_NAME, $request, $categoryTraining));

        return $response
            ->setPreviousUrl(route('category-training.index'))
            ->setNextUrl(route('category-training.edit', $categoryTraining->id))
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
        $categoryTraining = $this->categoryTrainingRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $categoryTraining));

        page_title()->setTitle(trans('plugins/category-training::category-training.edit') . ' "' . $categoryTraining->name . '"');

        return $formBuilder->create(CategoryTrainingForm::class, ['model' => $categoryTraining])->renderForm();
    }

    /**
     * @param $id
     * @param CategoryTrainingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CategoryTrainingRequest $request, BaseHttpResponse $response)
    {
        $categoryTraining = $this->categoryTrainingRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->categoryTrainingRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $categoryTraining->fill($request->input());

        $this->categoryTrainingRepository->createOrUpdate($categoryTraining);

        event(new UpdatedContentEvent(CATEGORY_TRAINING_MODULE_SCREEN_NAME, $request, $categoryTraining));

        return $response
            ->setPreviousUrl(route('category-training.index'))
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
            $categoryTraining = $this->categoryTrainingRepository->findOrFail($id);

            $this->categoryTrainingRepository->delete($categoryTraining);

            event(new DeletedContentEvent(CATEGORY_TRAINING_MODULE_SCREEN_NAME, $request, $categoryTraining));

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
            $categoryTraining = $this->categoryTrainingRepository->findOrFail($id);
            $this->categoryTrainingRepository->delete($categoryTraining);
            event(new DeletedContentEvent(CATEGORY_TRAINING_MODULE_SCREEN_NAME, $request, $categoryTraining));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
