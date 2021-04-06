<?php

namespace Platform\PostAssociates\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostAssociates\Http\Requests\PostAssociatesRequest;
use Platform\PostAssociates\Models\PostAssociates;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Platform\Blog\Forms\Fields\CategoryMultiField;

class PostAssociatesForm extends FormAbstract
{
    /**
     * @var string
     */
    protected $template = 'core/base::forms.form-tabs';

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {

        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories_associates()->pluck('category_associates_id')->all();
        }

        if (!$this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }
        
        if (empty($selectedCategories)) {
            $selectedCategories = app(CategoryAssociatesInterface::class)
                ->getModel()
                ->where('is_default', 1)
                ->pluck('id')
                ->all(); 
        }

        $this
            ->setupModel(new PostAssociates)
            ->setValidatorClass(PostAssociatesRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('create_url', 'text', [
                'label'      => trans('Liên kết'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                ],
            ])
            // ->add('description', 'textarea', [
            //     'label'      => trans('core/base::forms.description'),
            //     'label_attr' => ['class' => 'control-label'],
            //     'attr'       => [
            //         'rows'         => 4,
            //         'placeholder'  => trans('core/base::forms.description_placeholder'),
            //         'data-counter' => 400,
            //     ],
            // ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            // ->add('content', 'editor', [
            //     'label'      => trans('core/base::forms.content'),
            //     'label_attr' => ['class' => 'control-label'],
            //     'attr'       => [
            //         'rows'            => 4,
            //         'placeholder'     => trans('core/base::forms.description_placeholder'),
            //         'with-short-code' => true,
            //     ],
            // ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('format_type', 'customRadio', [
                'label'      => trans('plugins/blog::posts.form.format_type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_post_formats(true),
            ])
            ->add('category_associates[]', 'categoryMulti', [
                'label'      => trans('plugins/blog::posts.form.categories'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_category_associates_with_children(),
                'value'      => old('category_associates', $selectedCategories),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
                'help_block' => [
                    'text' => '<p class="btn btn-primary">Để chất lượng hiển thị được tốt nhất vui lòng tải lên ảnh có kích thước (1920x1080) pixel.</p>',
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
