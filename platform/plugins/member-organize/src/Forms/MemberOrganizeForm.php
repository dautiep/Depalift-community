<?php

namespace Platform\MemberOrganize\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Member\Models\Provinces;
use Platform\MemberOrganize\Forms\Fields\ActivityLastMultiField;
use Platform\MemberOrganize\Forms\Fields\ActivityMultiField;
use Platform\MemberOrganize\Forms\Fields\PurPoseMultiField;
use Platform\MemberOrganize\Http\Requests\MemberOrganizeRequest;
use Platform\MemberOrganize\Models\MemberOrganize;

class MemberOrganizeForm extends FormAbstract
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

        if (!$this->formHelper->hasCustomField('activityMulti')) {
            $this->formHelper->addCustomField('activityMulti', ActivityMultiField::class);
        }

        if (!$this->formHelper->hasCustomField('activityLastMulti')) {
            $this->formHelper->addCustomField('activityLastMulti', ActivityLastMultiField::class);
        }

        if (!$this->formHelper->hasCustomField('purposeMulti')) {
            $this->formHelper->addCustomField('purposeMulti', PurPoseMultiField::class);
        }


        $this
            ->setupModel(new MemberOrganize)
            ->setValidatorClass(MemberOrganizeRequest::class)
            ->withCustomFields()
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('guarantee_info', 'html', [
                'html'      => '<b class="text-info">THÔNG TIN TỔ CHỨC/DOANH NGHIỆP</b> <br>',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('name_vietnam', 'text', [
                'label'      => 'Tên tiếng Việt', 
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('name_english', 'text', [
                'label'      => 'Tên tiếng Anh',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
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
            ->add('name_sub', 'text', [
                'label'      => 'Tên viết tắt',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('num_business', 'text', [
                'label'      => 'Quyết định thành lập',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen3', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('date_start_at', 'date', [
                'label'      => 'Ngày cấp lần đầu',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('date_at', 'date', [
                'label'      => 'Ngày cấp thay đổi',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('type_business', 'text', [
                'label'      => 'Loại hình kinh doanh',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('rowClose3', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen4', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('pernament_main', 'customSelect', [
                'label'      => 'Địa chỉ TS chính(Tỉnh/Thành phố)',
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
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('address_main', 'text', [
                'label'      => 'Địa chỉ',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('pernament_sub', 'customSelect', [
                'label'      => 'Địa chỉ GD-Tỉnh/Thành phố (nếu có)',
                'label_attr' => ['class' => 'control-label'],
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
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('address_sub', 'text', [
                'label'      => 'Địa chỉ',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('phone', 'text', [
                'label'      => 'Số điện thoại',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('email', 'text', [
                'label'      => 'Email',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('link_web', 'text', [
                'label'      => 'Link website',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('fanpage', 'text', [
                'label'      => 'Link fanpage',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('representative', 'text', [
                'label'      => 'Họ tên người đại diện',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-4',
                ],
            ])
            ->add('position', 'text', [
                'label'      => 'Chức vụ người đại diện',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('member_info', 'html', [
                'html'      => '<b class="text-info">THÔNG TIN NGƯỜI ĐẠI DIỆN THAM GIA</b> <br>',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('name_member', 'text', [
                'label'      => 'Họ tên',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('position_member', 'text', [
                'label'      => 'Chức vụ',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
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
            ->add('phone_member', 'text', [
                'label'      => 'Số điện thoại',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('email_member', 'text', [
                'label'      => 'Email',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('rowClose9', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen10', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('business_info', 'html', [
                'html'      => '<b class="text-info">THÔNG TIN KINH DOANH</b> <br>',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('career_main', 'textarea', [
                'label'      => 'Sản phẩm, dịch vụ chính',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('logo_main', 'textarea', [
                'label'      => 'Tên thương hiệu, nhãn hiệu sản phẩm, dịch vụ chính(nếu có)',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('marketing_main', 'customSelect', [
                'label'      => 'Thị trường chính',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'select-search-full',
                ],
                'choices'    => $provinces,
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('shop', 'textarea', [
                'label'      => 'Chi nhánh, văn phòng tại các tỉnh',
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            ->add('total_staff', 'number', [
                'label'      => 'Tổng số CBNV',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            ->add('total_staff_tech', 'number', [
                'label'      => 'Tổng số nhân viên thang máy (nếu có)',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 191,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])
            
            ->add('activity[]', 'activityMulti', [
                'label'      => 'Các hoạt động chính',
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => '',
                'value'      => '',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])

            ->add('activity_for_latest_years[]', 'activityLastMulti', [
                'label'      => 'Thông tin kinh doanh 3 năm gần nhất',
                'label_attr' => ['class' => 'control-label'],
                'choices'    => '',
                'value'      => '',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])

            ->add('purpose[]', 'purposeMulti', [
                'label'      => 'Mục đích tham gia hiệp hội',
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => '',
                'value'      => '',
                'wrapper'    => [
                    'class' => 'form-group col-md-12',
                ],
            ])
            
            ->add('rowClose10', 'html', [
                'html' => '</div>',
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
