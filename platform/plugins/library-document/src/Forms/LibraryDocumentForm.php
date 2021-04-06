<?php

namespace Platform\LibraryDocument\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\LibraryCategory\Models\LibraryCategory;
use Platform\LibraryDocument\Http\Requests\LibraryDocumentRequest;
use Platform\LibraryDocument\Models\LibraryDocument;

class LibraryDocumentForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
		$selectedCategories = [];
		if ($this->getModel()) {
			$selectedCategories = $this->getModel()->category->id;
		}

		if (empty($selectedCategories)) {
			$selectedCategories = app(LibraryCategory::class)
				->getModel()
				->pluck('id')
				->all();
		}

        $this
            ->setupModel(new LibraryDocument)
            ->setValidatorClass(LibraryDocumentRequest::class)
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
			->add('library_category_id', 'customSelect', [
				'label' => __('Loại tài liệu'),
				'label_attr' => ['class' => 'control-label required '],
				'attr'       => [
					'class' => 'select-search-full',
				],
				'choices' => ['' => 'Chọn loại tài liệu'] + get_library_catrgories(),
				'value'      => old('library_category_id', $selectedCategories),
			])
			->add('featured', 'onOff', [
				'label' => __('Bài nổi bật'),
				'label_attr' => ['class' => 'control-label'],
				'default_value' => false,
			])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
			->add('thumbnail', 'mediaImage', [
				'label' =>trans('core/base::forms.image'),
				'label_attr' => ['class' => 'control-label'],
				'help_block' => [
                    'text' => '<p class="btn btn-primary">Để chất lượng hiển thị được tốt nhất vui lòng tải lên ảnh có kích thước (1920x1080) pixel.</p>',
                ],
			])
            ->setBreakFieldPoint('status');
    }
}