<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
Use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_categories_training')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_categories_training($limit, array $with = [])
    {
        return app(CategoryTrainingInterface::class)->getFeaturedCategoryTraining($limit, $with);
    }
}

if (!function_exists('get_all_categories_training')) {
    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    function get_all_categories_training(array $condition = [], $with = [])
    {
        return app(CategoryTrainingInterface::class)->getAllCategoryTraining($condition, $with);
    }
}

if (!function_exists('get_category_training_by_id')) {
    /**
     * @param integer $id
     * @return array
     */
    function get_category_training_by_id($id)
    {
        return app(CategoryTrainingInterface::class)->getCategoryTrainingById($id);
    }
}

if (!function_exists('get_categories_training')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_categories_training(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(CategoryTrainingInterface::class);

        $category_training = $repo->getCategoryTraining(Arr::get($args, 'select', ['*']), [
            'app_category_training.created_at' => 'DESC',
            'app_category_training.is_default' => 'DESC',
            'app_category_training.order'      => 'ASC',
        ]);

        $category_training = sort_item_with_children($category_training);

        foreach ($category_training as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($index = 0; $index < $depth; $index++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $category_training;
    }
}

if (!function_exists('get_category_training_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_category_training_with_children()
    {
        $category_events = app(CategoryTrainingInterface::class)
            ->getAllCategoryTrainingWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($category_events);

        return $sortHelper->sort();
    }
}

if (!function_exists('get_category_by_post_training')) {
    /**
     * @param int $id_post
     * @return array
     */
    function get_category_by_post_training($id_post)
    {
        return app(CategoryTrainingInterface::class)->getCategoryByPostTraining($id_post);
    }
}