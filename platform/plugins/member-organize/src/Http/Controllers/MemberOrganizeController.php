<?php

namespace Platform\MemberOrganize\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\MemberOrganize\Http\Requests\MemberOrganizeRequest;
use Platform\MemberOrganize\Repositories\Interfaces\MemberOrganizeInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\MemberOrganize\Tables\MemberOrganizeTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\MemberOrganize\Forms\MemberOrganizeForm;
use Platform\Base\Forms\FormBuilder;
use Platform\MemberOrganize\Models\MemberOrganize;

class MemberOrganizeController extends BaseController
{
    /**
     * @var MemberOrganizeInterface
     */
    protected $memberOrganizeRepository;

    /**
     * @param MemberOrganizeInterface $memberOrganizeRepository
     */
    public function __construct(MemberOrganizeInterface $memberOrganizeRepository)
    {
        $this->memberOrganizeRepository = $memberOrganizeRepository;
    }

    /**
     * @param MemberOrganizeTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(MemberOrganizeTable $table)
    {
        page_title()->setTitle(trans('plugins/member-organize::member-organize.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/member-organize::member-organize.create'));

        return $formBuilder->create(MemberOrganizeForm::class)->renderForm();
    }

    /**
     * @param MemberOrganizeRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(MemberOrganizeRequest $request, BaseHttpResponse $response)
    {
        $memberOrganize = $this->memberOrganizeRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MEMBER_ORGANIZE_MODULE_SCREEN_NAME, $request, $memberOrganize));

        return $response
            ->setPreviousUrl(route('member-organize.index'))
            ->setNextUrl(route('member-organize.edit', $memberOrganize->id))
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
        $memberOrganize = $this->memberOrganizeRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $memberOrganize));

        page_title()->setTitle(trans('plugins/member-organize::member-organize.edit') . ' "' . $memberOrganize->name . '"');

        return $formBuilder->create(MemberOrganizeForm::class, ['model' => $memberOrganize])->renderForm();
    }

    /**
     * @param $id
     * @param MemberOrganizeRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, MemberOrganizeRequest $request, BaseHttpResponse $response)
    {
        $memberOrganize = MemberOrganize::where('id', $id)->first();
        $input = $request->all();
        $request->activity = json_encode($request->activity);
        $input['activity'] = $request->activity;
        $request->activity_for_latest_years = json_encode($request->activity_for_latest_years);
        $input['activity_for_latest_years'] = $request->activity_for_latest_years;
        $request->purpose = json_encode($request->purpose);
        $input['purpose'] = $request->purpose;
        $memberOrganize->update($input);

        event(new UpdatedContentEvent(MEMBER_ORGANIZE_MODULE_SCREEN_NAME, $request, $memberOrganize));

        return $response
            ->setPreviousUrl(route('member-organize.index'))
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
            $memberOrganize = $this->memberOrganizeRepository->findOrFail($id);

            $this->memberOrganizeRepository->delete($memberOrganize);

            event(new DeletedContentEvent(MEMBER_ORGANIZE_MODULE_SCREEN_NAME, $request, $memberOrganize));

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
            $memberOrganize = $this->memberOrganizeRepository->findOrFail($id);
            $this->memberOrganizeRepository->delete($memberOrganize);
            event(new DeletedContentEvent(MEMBER_ORGANIZE_MODULE_SCREEN_NAME, $request, $memberOrganize));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
