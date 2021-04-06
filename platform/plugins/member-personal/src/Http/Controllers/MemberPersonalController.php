<?php

namespace Platform\MemberPersonal\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\MemberPersonal\Http\Requests\MemberPersonalRequest;
use Platform\MemberPersonal\Repositories\Interfaces\MemberPersonalInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\MemberPersonal\Tables\MemberPersonalTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\MemberPersonal\Forms\MemberPersonalForm;
use Platform\Base\Forms\FormBuilder;
use Platform\MemberPersonal\Models\MemberPersonal;

class MemberPersonalController extends BaseController
{
    /**
     * @var MemberPersonalInterface
     */
    protected $memberPersonalRepository;

    /**
     * @param MemberPersonalInterface $memberPersonalRepository
     */
    public function __construct(MemberPersonalInterface $memberPersonalRepository)
    {
        $this->memberPersonalRepository = $memberPersonalRepository;
    }

    /**
     * @param MemberPersonalTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(MemberPersonalTable $table)
    {
        page_title()->setTitle(trans('plugins/member-personal::member-personal.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/member-personal::member-personal.create'));

        return $formBuilder->create(MemberPersonalForm::class)->renderForm();
    }

    /**
     * @param MemberPersonalRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(MemberPersonalRequest $request, BaseHttpResponse $response)
    {
        $memberPersonal = $this->memberPersonalRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MEMBER_PERSONAL_MODULE_SCREEN_NAME, $request, $memberPersonal));

        return $response
            ->setPreviousUrl(route('member-personal.index'))
            ->setNextUrl(route('member-personal.edit', $memberPersonal->id))
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
        $memberPersonal = $this->memberPersonalRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $memberPersonal));

        page_title()->setTitle(trans('plugins/member-personal::member-personal.edit') . ' "' . $memberPersonal->name . '"');

        return $formBuilder->create(MemberPersonalForm::class, ['model' => $memberPersonal])->renderForm();
    }

    /**
     * @param $id
     * @param MemberPersonalRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, MemberPersonalRequest $request, BaseHttpResponse $response)
    {
        $memberPersonal = MemberPersonal::where('id', $id)->first();
        $input = $request->all();
        $request->purposes = json_encode($request->purposes);
        $input['purpose'] = $request->purposes;
        $memberPersonal->update($input);

        event(new UpdatedContentEvent(MEMBER_PERSONAL_MODULE_SCREEN_NAME, $request, $memberPersonal));

        return $response
            ->setPreviousUrl(route('member-personal.index'))
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
            $memberPersonal = $this->memberPersonalRepository->findOrFail($id);

            $this->memberPersonalRepository->delete($memberPersonal);

            event(new DeletedContentEvent(MEMBER_PERSONAL_MODULE_SCREEN_NAME, $request, $memberPersonal));

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
            $memberPersonal = $this->memberPersonalRepository->findOrFail($id);
            $this->memberPersonalRepository->delete($memberPersonal);
            event(new DeletedContentEvent(MEMBER_PERSONAL_MODULE_SCREEN_NAME, $request, $memberPersonal));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
