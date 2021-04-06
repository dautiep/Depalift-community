<?php

namespace Platform\PostEvents\Forms;

use Platform\Base\Forms\FormAbstract;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostEvents\Http\Requests\PostEventsRequest;
use Platform\PostEvents\Models\PostEvents;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Platform\Blog\Forms\Fields\CategoryMultiField;

class PostEventsForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'core/base::forms.form-tabs';

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function buildForm()
    {
       $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories_events()->pluck('category_events_id')->all();    
        }

        if (!$this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }
        
        if (empty($selectedCategories)) {
            $selectedCategories = app(CategoryEventsInterface::class)
                ->getModel()
                ->where('is_default', 1)
                -> pluck('id')
                ->all(); 
        }

        $this
            ->setupModel(new PostEvents)
            ->setValidatorClass(PostEventsRequest::class)
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
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('content', 'editor', [
                'label'      => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
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
            ->add('category_events[]', 'categoryMulti', [
                'label'      => trans('plugins/blog::posts.form.categories'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_category_events_with_children(),
                'value'      => old('category_events', $selectedCategories),
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
