<?php

namespace Platform\LibraryCategory\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\LibraryCategory\Http\Requests\LibraryCategoryRequest;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\LibraryCategory\Tables\LibraryCategoryTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\LibraryCategory\Forms\LibraryCategoryForm;
use Platform\Base\Forms\FormBuilder;

class LibraryCategoryController extends BaseController
{
    /**
     * @var LibraryCategoryInterface
     */
    protected $libraryCategoryRepository;

    /**
     * @param LibraryCategoryInterface $libraryCategoryRepository
     */
    public function __construct(LibraryCategoryInterface $libraryCategoryRepository)
    {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
    }

    /**
     * @param LibraryCategoryTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(LibraryCategoryTable $table)
    {
        page_title()->setTitle(trans('plugins/library-category::library-category.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/library-category::library-category.create'));

        return $formBuilder->create(LibraryCategoryForm::class)->renderForm();
    }

    /**
     * @param LibraryCategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(LibraryCategoryRequest $request, BaseHttpResponse $response)
    {
        $libraryCategory = $this->libraryCategoryRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(LIBRARY_CATEGORY_MODULE_SCREEN_NAME, $request, $libraryCategory));

        return $response
            ->setPreviousUrl(route('library-category.index'))
            ->setNextUrl(route('library-category.edit', $libraryCategory->id))
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
        $libraryCategory = $this->libraryCategoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $libraryCategory));

        page_title()->setTitle(trans('plugins/library-category::library-category.edit') . ' "' . $libraryCategory->name . '"');

        return $formBuilder->create(LibraryCategoryForm::class, ['model' => $libraryCategory])->renderForm();
    }

    /**
     * @param $id
     * @param LibraryCategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, LibraryCategoryRequest $request, BaseHttpResponse $response)
    {
        $libraryCategory = $this->libraryCategoryRepository->findOrFail($id);

        $libraryCategory->fill($request->input());

        $this->libraryCategoryRepository->createOrUpdate($libraryCategory);

        event(new UpdatedContentEvent(LIBRARY_CATEGORY_MODULE_SCREEN_NAME, $request, $libraryCategory));

        return $response
            ->setPreviousUrl(route('library-category.index'))
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
            $libraryCategory = $this->libraryCategoryRepository->findOrFail($id);

            $this->libraryCategoryRepository->delete($libraryCategory);

            event(new DeletedContentEvent(LIBRARY_CATEGORY_MODULE_SCREEN_NAME, $request, $libraryCategory));

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
            $libraryCategory = $this->libraryCategoryRepository->findOrFail($id);
            $this->libraryCategoryRepository->delete($libraryCategory);
            event(new DeletedContentEvent(LIBRARY_CATEGORY_MODULE_SCREEN_NAME, $request, $libraryCategory));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
