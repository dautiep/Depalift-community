<?php

namespace Platform\CategoryEvents\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\CategoryEvents\Http\Requests\CategoryEventsRequest;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Platform\CategoryEvents\Tables\CategoryEventsTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\CategoryEvents\Forms\CategoryEventsForm;
use Platform\Base\Forms\FormBuilder;
use Throwable;

class CategoryEventsController extends BaseController
{
    /**
     * @var CategoryEventsInterface
     */
    protected $categoryEventsRepository;

    /**
     * @param CategoryEventsInterface $categoryEventsRepository
     */
    public function __construct(CategoryEventsInterface $categoryEventsRepository)
    {
        $this->categoryEventsRepository = $categoryEventsRepository;
    }

    /**
     * @param CategoryEventsTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Throwable
     */
    public function index(CategoryEventsTable $table)
    {
        page_title()->setTitle(trans('plugins/category-events::category-events.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/category-events::category-events.create'));

        return $formBuilder->create(CategoryEventsForm::class)->renderForm();
    }

    /**
     * @param CategoryEventsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CategoryEventsRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->categoryEventsRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $categoryEvents = $this->categoryEventsRepository->createOrUpdate(array_merge($request->input(),['author_id' => Auth::user()->getKey(),]));

        event(new CreatedContentEvent(CATEGORY_EVENTS_MODULE_SCREEN_NAME, $request, $categoryEvents));

        return $response
            ->setPreviousUrl(route('category-events.index'))
            ->setNextUrl(route('category-events.edit', $categoryEvents->id))
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
        $categoryEvents = $this->categoryEventsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $categoryEvents));

        page_title()->setTitle(trans('plugins/category-events::category-events.edit') . ' "' . $categoryEvents->name . '"');

        return $formBuilder->create(CategoryEventsForm::class, ['model' => $categoryEvents])->renderForm();
    }

    /**
     * @param $id
     * @param CategoryEventsRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CategoryEventsRequest $request, BaseHttpResponse $response)
    {
        $categoryEvents = $this->categoryEventsRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->categoryEventsRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $categoryEvents->fill($request->input());

        $this->categoryEventsRepository->createOrUpdate($categoryEvents);

        event(new UpdatedContentEvent(CATEGORY_EVENTS_MODULE_SCREEN_NAME, $request, $categoryEvents));

        return $response
            ->setPreviousUrl(route('category-events.index'))
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
            $categoryEvents = $this->categoryEventsRepository->findOrFail($id);

            if(!$categoryEvents->is_default){
                $this->categoryEventsRepository->delete($categoryEvents);
                event(new DeletedContentEvent(CATEGORY_EVENTS_MODULE_SCREEN_NAME, $request, $categoryEvents));
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
            $categoryEvents = $this->categoryEventsRepository->findOrFail($id);
            $this->categoryEventsRepository->delete($categoryEvents);
            event(new DeletedContentEvent(CATEGORY_EVENTS_MODULE_SCREEN_NAME, $request, $categoryEvents));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
