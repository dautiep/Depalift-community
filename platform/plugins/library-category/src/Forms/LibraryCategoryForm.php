<?php

namespace Platform\LibraryCategory\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\LibraryCategory\Http\Requests\LibraryCategoryRequest;
use Platform\LibraryCategory\Models\LibraryCategory;

class LibraryCategoryForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new LibraryCategory)
            ->setValidatorClass(LibraryCategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
			->add('description', 'textarea', [
				'label'      => trans('Mô tả'),
				'label_attr' => ['class' => 'control-label'],
				'attr'       => [
					'placeholder'  => trans('Nhập mô tả'),
					'data-counter' => 190,
					'rows' => 3
				],
			])
			->add('image', 'mediaImage', [
				'label'      => trans('Hình ảnh thumbnail'),
				'label_attr' => ['class' => 'control-label'],
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
