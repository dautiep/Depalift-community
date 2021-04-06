<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_categories_events')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_categories_events($limit, array $with = [])
    {
        return app(CategoryEventsInterface::class)->getFeaturedCategories($limit, $with);
    }
}

if (!function_exists('get_all_categories_events')) {
    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    function get_all_categories_events(array $condition = [], $with = [])
    {
        return app(CategoryEventsInterface::class)->getAllCategoriesEvents($condition, $with);
    }
}

if (!function_exists('get_category_events_by_id')) {
    /**
     * @param integer $id
     * @return array
     */
    function get_category_events_by_id($id)
    {
        return app(CategoryEventsInterface::class)->getCategoryById($id);
    }
}

if (!function_exists('get_categories_events')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_categories_events(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(CategoryEventsInterface::class);

        $category_events = $repo->getCategoriesEvents(Arr::get($args, 'select', ['*']), [
            'app_category_events.created_at' => 'DESC',
            'app_category_events.is_default' => 'DESC',
            'app_category_events.order'      => 'ASC',
        ]);

        $category_events = sort_item_with_children($category_events);

        foreach ($category_events as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($index = 0; $index < $depth; $index++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $category_events;
    }
}

if (!function_exists('get_category_events_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_category_events_with_children()
    {
        $category_events = app(CategoryEventsInterface::class)
            ->getAllCategoryEventsWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($category_events);

        return $sortHelper->sort();
    }
}

if (!function_exists('get_category_by_post_events')) {
    /**
     * @param int $id_post
     * @return array
     */
    function get_category_by_post_events($id_post)
    {
        return app(CategoryEventsInterface::class)->getCategoryByPostEvents($id_post);
    }
}