<?php

namespace Platform\PostEvents\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\PostEvents\Http\Requests\PostEventsRequest;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\PostEvents\Tables\PostEventsTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\PostEvents\Forms\PostEventsForm;
use Platform\Base\Forms\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Illuminate\Contracts\View\Factory;
use Platform\CategoryEvents\Services\CategoryEventsService;
use Throwable;
use Platform\Base\Traits\HasDeleteManyItemsTrait;
use Illuminate\View\View;
use Platform\PostEvents\Services\StoreCategoryService;

class PostEventsController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var PostEventsInterface
     */
    protected $postEventsRepository;

    /**
     * @var CategoryEventsInterface
     */
    protected $categoryEventsRepository;

    /**
     * @param PostEventsInterface $postEventsRepository
     * @param CategoryEventsInterface $categoryEventsRepository
     */
    public function __construct(
        PostEventsInterface $postEventsRepository,
        CategoryEventsInterface $categoryEventsRepository
        )
    {
        $this->postEventsRepository = $postEventsRepository;
        $this->categoryEventsRepository = $categoryEventsRepository;
    }

    /**
     * @param PostEventsTable $table
     * @return Factory|View
     * @throws Throwable
     */
    public function index(PostEventsTable $table)
    {
        page_title()->setTitle(trans('plugins/post-events::post-events.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/post-events::post-events.create'));

        return $formBuilder->create(PostEventsForm::class)->renderForm();
    }

    /**
     * @param PostEventsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PostEventsRequest $request, BaseHttpResponse $response, StoreCategoryService $storeCategoryService)
    {
        $postEvents = $this->postEventsRepository->createOrUpdate(array_merge($request->input(),['author_id' => Auth::user()->getKey()]));
        
        event(new CreatedContentEvent(POST_EVENTS_MODULE_SCREEN_NAME, $request, $postEvents));

        $storeCategoryService->execute($request, $postEvents);
        
        return $response
            ->setPreviousUrl(route('post-events.index'))
            ->setNextUrl(route('post-events.edit', $postEvents->id))
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
        $postEvents = $this->postEventsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $postEvents));

        page_title()->setTitle(trans('plugins/post-events::post-events.edit') . ' "' . $postEvents->name . '"');

        return $formBuilder->create(PostEventsForm::class, ['model' => $postEvents])->renderForm();
    }

    /**
     * @param $id
     * @param PostEventsRequest $request
     * @param BaseHttpResponse $response
     * @param CategoryEventsService $categoryEventsService
     * @return BaseHttpResponse
     */
    public function update($id, PostEventsRequest $request, BaseHttpResponse $response, StoreCategoryService $storeCategoryService)
    {
        $postEvents = $this->postEventsRepository->findOrFail($id);
        
        $postEvents->fill($request->input());

        $this->postEventsRepository->createOrUpdate($postEvents);

        event(new UpdatedContentEvent(POST_EVENTS_MODULE_SCREEN_NAME, $request, $postEvents));

        $storeCategoryService->execute($request, $postEvents);

        return $response
            ->setPreviousUrl(route('post-events.index'))
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
            $postEvents = $this->postEventsRepository->findOrFail($id);

            $this->postEventsRepository->delete($postEvents);

            event(new DeletedContentEvent(POST_EVENTS_MODULE_SCREEN_NAME, $request, $postEvents));

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
            $postEvents = $this->postEventsRepository->findOrFail($id);
            $this->postEventsRepository->delete($postEvents);
            event(new DeletedContentEvent(POST_EVENTS_MODULE_SCREEN_NAME, $request, $postEvents));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
