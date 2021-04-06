<?php

namespace Platform\PostAssociates\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\PostAssociates\Http\Requests\PostAssociatesRequest;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\PostAssociates\Tables\PostAssociatesTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\PostAssociates\Forms\PostAssociatesForm;
use Platform\Base\Forms\FormBuilder;
use Platform\PostAssociates\Services\StoreCategoryAssociatesService;
use Illuminate\Support\Facades\Auth;

class PostAssociatesController extends BaseController
{
    /**
     * @var PostAssociatesInterface
     */
    protected $postAssociatesRepository;

    /**
     * @param PostAssociatesInterface $postAssociatesRepository
     */
    public function __construct(PostAssociatesInterface $postAssociatesRepository)
    {
        $this->postAssociatesRepository = $postAssociatesRepository;
    }

    /**
     * @param PostAssociatesTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PostAssociatesTable $table)
    {
        page_title()->setTitle(trans('plugins/post-associates::post-associates.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/post-associates::post-associates.create'));

        return $formBuilder->create(PostAssociatesForm::class)->renderForm();
    }

    /**
     * @param PostAssociatesRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PostAssociatesRequest $request, BaseHttpResponse $response, StoreCategoryAssociatesService $storeCategoryAssociatesService)
    {
        $postAssociates = $this->postAssociatesRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(POST_ASSOCIATES_MODULE_SCREEN_NAME, $request, $postAssociates));

        $storeCategoryAssociatesService->execute($request, $postAssociates);

        return $response
            ->setPreviousUrl(route('post-associates.index'))
            ->setNextUrl(route('post-associates.edit', $postAssociates->id))
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
        $postAssociates = $this->postAssociatesRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $postAssociates));

        page_title()->setTitle(trans('plugins/post-associates::post-associates.edit') . ' "' . $postAssociates->name . '"');

        return $formBuilder->create(PostAssociatesForm::class, ['model' => $postAssociates])->renderForm();
    }

    /**
     * @param $id
     * @param PostAssociatesRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, PostAssociatesRequest $request, BaseHttpResponse $response, StoreCategoryAssociatesService $storeCategoryAssociatesService)
    {
        $postAssociates = $this->postAssociatesRepository->findOrFail($id);

        $postAssociates->fill($request->input());

        $this->postAssociatesRepository->createOrUpdate($postAssociates);

        event(new UpdatedContentEvent(POST_ASSOCIATES_MODULE_SCREEN_NAME, $request, $postAssociates));

        $storeCategoryAssociatesService->execute($request, $postAssociates);

        return $response
            ->setPreviousUrl(route('post-associates.index'))
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
            $postAssociates = $this->postAssociatesRepository->findOrFail($id);

            $this->postAssociatesRepository->delete($postAssociates);

            event(new DeletedContentEvent(POST_ASSOCIATES_MODULE_SCREEN_NAME, $request, $postAssociates));

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
            $postAssociates = $this->postAssociatesRepository->findOrFail($id);
            $this->postAssociatesRepository->delete($postAssociates);
            event(new DeletedContentEvent(POST_ASSOCIATES_MODULE_SCREEN_NAME, $request, $postAssociates));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
