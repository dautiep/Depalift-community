<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_categories_associates')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_categories_associates($limit, array $with = [])
    {
        return app(CategoryAssociatesInterface::class)->getFeaturedCategoryAssociates($limit, $with);
    }
}

if (!function_exists('get_all_categories_associates')) {
    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    function get_all_categories_associates(array $condition = [], $with = [])
    {
        return app(CategoryAssociatesInterface::class)->getAllCategoryAssociates($condition, $with);
    }
}

if (!function_exists('get_category_by_id_associates')) {
    /**
     * @param integer $id
     * @return array
     */
    function get_category_associates_by_id($id)
    {
        return app(CategoryAssociatesInterface::class)->getCategoryAssociatesById($id);
    }
}

if (!function_exists('get_categories_associates')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_categories_associates(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(CategoryAssociatesInterface::class);

        $category_associates = $repo->getCategoryAssociates(Arr::get($args, 'select', ['*']), [
            'app_category_associates.created_at' => 'DESC',
            'app_category_associates.is_default' => 'DESC',
            'app_category_associates.order'      => 'ASC',
        ]);

        $category_associates = sort_item_with_children($category_associates);

        foreach ($category_associates as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($index = 0; $index < $depth; $index++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $category_associates;
    }
}

if (!function_exists('get_category_associates_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_category_associates_with_children()
    {
        $category_associates = app(CategoryAssociatesInterface::class)
            ->getAllCategoryAssociatesWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($category_associates);

        return $sortHelper->sort();
    }
}