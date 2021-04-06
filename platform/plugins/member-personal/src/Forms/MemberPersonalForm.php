<?php

namespace Platform\MemberPersonal\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Member\Models\Provinces;
use Platform\MemberPersonal\Forms\Fields\PurPoseMultiField;
use Platform\MemberPersonal\Http\Requests\MemberPersonalRequest;
use Platform\MemberPersonal\Models\MemberPersonal;

class MemberPersonalForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $provinces =app(Provinces::class)
                    ->getModel()
                    ->pluck('name', 'name')
                    ->toArray();

        if (!$this->formHelper->hasCustomField('purposeMulti')) {
            $this->formHelper->addCustomField('purposeMulti', PurPoseMultiField::class);
        }
        $this
            ->setupModel(new MemberPersonal)
            ->setValidatorClass(MemberPersonalRequest::class)
            ->withCustomFields()
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('guarantee_info', 'html', [
                'html'      => '<b class="text-info">THÔNG TIN CÁ NHÂN</b> <br>',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('sex', 'select', [
                'label'      => 'Giới tính',
                'label_attr' => ['class' => 'control-label'],
                'choices'    => [
                    0 => __('Nam'),
                    1 => __('Nữ'),
                    2 => __('Khác'),
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('birth_day', 'date', [
                'label'      => 'Ngày sinh',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('place_birth', 'customSelect', [
                'label'      => 'Nơi sinh',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $provinces,
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen3', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('country', 'text', [
                'label'      => 'Quốc tịch',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('religion', 'text', [
                'label'      => 'Tôn giáo',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose3', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen4', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('identify', 'text', [
                'label'      => 'CMND',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('date_range', 'date', [
                'label'      => 'Ngày cấp',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('issued_by', 'customSelect', [
                'label'      => 'Nơi cấp',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $provinces,
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose4', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen5', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('pernament_main', 'customSelect', [
                'label'      => 'Địa chỉ thường trú(Tỉnh/Thành phố)',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $provinces,
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('district_main', 'text', [
                'label'      => 'Quận/Huyện',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('address_main', 'text', [
                'label'      => 'Địa chỉ',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose5', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen6', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('pernament_sub', 'customSelect', [
                'label'      => 'Địa chỉ liên hệ(Tỉnh/Thành phố)',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $provinces,
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('district_sub', 'text', [
                'label'      => 'Quận/Huyện',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('address_sub', 'text', [
                'label'      => 'Địa chỉ',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose6', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen7', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('mail', 'email', [
                'label'      => 'Email',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('num_phone', 'text', [
                'label'      => 'Số điện thoại',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('link_fb', 'text', [
                'label'      => 'Facebook/Instagram',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose7', 'html', [
                'html' => '</div>',
            ])

            ->add('rowOpen8', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('job_info', 'html', [
                'html'      => '<br> <b class="text-info">THÔNG TIN CÔNG VIỆC</b> <br> ',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('education', 'text', [
                'label'      => 'Học vấn chuyên môn',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('works', 'text', [
                'label'      => 'Số năm làm việc thực tế',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose8', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen9', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('work_place', 'text', [
                'label'      => 'Nơi công tác hiện nay',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('position', 'text', [
                'label'      => 'Chức vụ/Vị trí',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose9', 'html', [
                'html' => '</div>',
            ])
            
            ->add('address_work', 'text', [
                'label'      => 'Địa chỉ làm việc hiện nay',
                'label_attr' => ['class' => 'control-label required'],
            ])
            ->add('degree', 'text', [
                'label'      => 'Các bằng cấp liên quan',
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('capacity', 'text', [
                'label'      => 'Năng lực thế mạnh',
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('purpose[]', 'purposeMulti', [
                'label'      => 'Mục đích tham gia hiệp hội',
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => '',
                'value'      => '',
                
            ])
            
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}