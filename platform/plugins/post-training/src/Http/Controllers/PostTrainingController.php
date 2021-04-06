<?php

namespace Platform\PostTraining\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\PostTraining\Http\Requests\PostTrainingRequest;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\PostTraining\Tables\PostTrainingTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\PostTraining\Forms\PostTrainingForm;
use Platform\Base\Forms\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Platform\PostTraining\Services\StoreCategoryTrainingService;

class PostTrainingController extends BaseController
{
    /**
     * @var PostTrainingInterface
     */
    protected $postTrainingRepository;

    /**
     * @param PostTrainingInterface $postTrainingRepository
     */
    public function __construct(PostTrainingInterface $postTrainingRepository)
    {
        $this->postTrainingRepository = $postTrainingRepository;
    }

    /**
     * @param PostTrainingTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PostTrainingTable $table)
    {
        page_title()->setTitle(trans('plugins/post-training::post-training.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/post-training::post-training.create'));

        return $formBuilder->create(PostTrainingForm::class)->renderForm();
    }

    /**
     * @param PostTrainingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PostTrainingRequest $request, BaseHttpResponse $response, StoreCategoryTrainingService $storeCategoryTrainingService)
    {
        $postTraining = $this->postTrainingRepository->createOrUpdate(array_merge($request->input(),['author_id' => Auth::user()->getKey(),]));
        
        event(new CreatedContentEvent(POST_TRAINING_MODULE_SCREEN_NAME, $request, $postTraining));

        $storeCategoryTrainingService->execute($request, $postTraining);

        return $response
            ->setPreviousUrl(route('post-training.index'))
            ->setNextUrl(route('post-training.edit', $postTraining->id))
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
        $postTraining = $this->postTrainingRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $postTraining));

        page_title()->setTitle(trans('plugins/post-training::post-training.edit') . ' "' . $postTraining->name . '"');

        return $formBuilder->create(PostTrainingForm::class, ['model' => $postTraining])->renderForm();
    }

    /**
     * @param $id
     * @param PostTrainingRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, PostTrainingRequest $request, BaseHttpResponse $response, StoreCategoryTrainingService $storeCategoryTrainingService)
    {
        $postTraining = $this->postTrainingRepository->findOrFail($id);

        $postTraining->fill($request->input());

        $this->postTrainingRepository->createOrUpdate($postTraining);

        event(new UpdatedContentEvent(POST_TRAINING_MODULE_SCREEN_NAME, $request, $postTraining));

        $storeCategoryTrainingService->execute($request, $postTraining);

        return $response
            ->setPreviousUrl(route('post-training.index'))
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
            $postTraining = $this->postTrainingRepository->findOrFail($id);

            $this->postTrainingRepository->delete($postTraining);

            event(new DeletedContentEvent(POST_TRAINING_MODULE_SCREEN_NAME, $request, $postTraining));

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
            $postTraining = $this->postTrainingRepository->findOrFail($id);
            $this->postTrainingRepository->delete($postTraining);
            event(new DeletedContentEvent(POST_TRAINING_MODULE_SCREEN_NAME, $request, $postTraining));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
