<?php

namespace Platform\PostProducer\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\PostProducer\Http\Requests\PostProducerRequest;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\PostProducer\Tables\PostProducerTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\PostProducer\Forms\PostProducerForm;
use Platform\Base\Forms\FormBuilder;
use Illuminate\Support\Facades\Auth;

class PostProducerController extends BaseController
{
    /**
     * @var PostProducerInterface
     */
    protected $postProducerRepository;

    /**
     * @param PostProducerInterface $postProducerRepository
     */
    public function __construct(PostProducerInterface $postProducerRepository)
    {
        $this->postProducerRepository = $postProducerRepository;
    }

    /**
     * @param PostProducerTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PostProducerTable $table)
    {
        page_title()->setTitle(trans('plugins/post-producer::post-producer.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/post-producer::post-producer.create'));

        return $formBuilder->create(PostProducerForm::class)->renderForm();
    }

    /**
     * @param PostProducerRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PostProducerRequest $request, BaseHttpResponse $response)
    {
        $postProducer = $this->postProducerRepository->createOrUpdate(array_merge($request->input(),['author_id' => Auth::user()->getKey()]));

        event(new CreatedContentEvent(POST_PRODUCER_MODULE_SCREEN_NAME, $request, $postProducer));

        return $response
            ->setPreviousUrl(route('post-producer.index'))
            ->setNextUrl(route('post-producer.edit', $postProducer->id))
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
        $postProducer = $this->postProducerRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $postProducer));

        page_title()->setTitle(trans('plugins/post-producer::post-producer.edit') . ' "' . $postProducer->name . '"');

        return $formBuilder->create(PostProducerForm::class, ['model' => $postProducer])->renderForm();
    }

    /**
     * @param $id
     * @param PostProducerRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, PostProducerRequest $request, BaseHttpResponse $response)
    {
        $postProducer = $this->postProducerRepository->findOrFail($id);

        $postProducer->fill($request->input());

        $this->postProducerRepository->createOrUpdate($postProducer);

        event(new UpdatedContentEvent(POST_PRODUCER_MODULE_SCREEN_NAME, $request, $postProducer));

        return $response
            ->setPreviousUrl(route('post-producer.index'))
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
            $postProducer = $this->postProducerRepository->findOrFail($id);

            $this->postProducerRepository->delete($postProducer);

            event(new DeletedContentEvent(POST_PRODUCER_MODULE_SCREEN_NAME, $request, $postProducer));

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
            $postProducer = $this->postProducerRepository->findOrFail($id);
            $this->postProducerRepository->delete($postProducer);
            event(new DeletedContentEvent(POST_PRODUCER_MODULE_SCREEN_NAME, $request, $postProducer));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
