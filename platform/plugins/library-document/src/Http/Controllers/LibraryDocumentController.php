<?php

namespace Platform\LibraryDocument\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\LibraryDocument\Http\Requests\LibraryDocumentRequest;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\LibraryDocument\Tables\LibraryDocumentTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\LibraryDocument\Forms\LibraryDocumentForm;
use Platform\Base\Forms\FormBuilder;

class LibraryDocumentController extends BaseController
{
    /**
     * @var LibraryDocumentInterface
     */
    protected $libraryDocumentRepository;

    /**
     * @param LibraryDocumentInterface $libraryDocumentRepository
     */
    public function __construct(LibraryDocumentInterface $libraryDocumentRepository)
    {
        $this->libraryDocumentRepository = $libraryDocumentRepository;
    }

    /**
     * @param LibraryDocumentTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(LibraryDocumentTable $table)
    {
        page_title()->setTitle(trans('plugins/library-document::library-document.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/library-document::library-document.create'));

        return $formBuilder->create(LibraryDocumentForm::class)->renderForm();
    }

    /**
     * @param LibraryDocumentRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(LibraryDocumentRequest $request, BaseHttpResponse $response)
    {
        $libraryDocument = $this->libraryDocumentRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(LIBRARY_DOCUMENT_MODULE_SCREEN_NAME, $request, $libraryDocument));

        return $response
            ->setPreviousUrl(route('library-document.index'))
            ->setNextUrl(route('library-document.edit', $libraryDocument->id))
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
        $libraryDocument = $this->libraryDocumentRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $libraryDocument));

        page_title()->setTitle(trans('plugins/library-document::library-document.edit') . ' "' . $libraryDocument->name . '"');

        return $formBuilder->create(LibraryDocumentForm::class, ['model' => $libraryDocument])->renderForm();
    }

    /**
     * @param $id
     * @param LibraryDocumentRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, LibraryDocumentRequest $request, BaseHttpResponse $response)
    {
        $libraryDocument = $this->libraryDocumentRepository->findOrFail($id);

        $libraryDocument->fill($request->input());

        $this->libraryDocumentRepository->createOrUpdate($libraryDocument);

        event(new UpdatedContentEvent(LIBRARY_DOCUMENT_MODULE_SCREEN_NAME, $request, $libraryDocument));

        return $response
            ->setPreviousUrl(route('library-document.index'))
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
            $libraryDocument = $this->libraryDocumentRepository->findOrFail($id);

            $this->libraryDocumentRepository->delete($libraryDocument);

            event(new DeletedContentEvent(LIBRARY_DOCUMENT_MODULE_SCREEN_NAME, $request, $libraryDocument));

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
            $libraryDocument = $this->libraryDocumentRepository->findOrFail($id);
            $this->libraryDocumentRepository->delete($libraryDocument);
            event(new DeletedContentEvent(LIBRARY_DOCUMENT_MODULE_SCREEN_NAME, $request, $libraryDocument));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
