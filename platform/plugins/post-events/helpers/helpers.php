<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_posts_events')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_posts_events($limit, array $with = [])
    {
        return app(PostEventsInterface::class)->getFeatured_events($limit, $with);
    }
}

if (!function_exists('get_latest_post_events')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_post_events($limit, $excepts = [])
    {
        return app(PostEventsInterface::class)->getListPostEventsNonInList($excepts, $limit);
    }
}

if (!function_exists('get_related_posts_events')) {
    /**
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_related_posts_events($id, $limit)
    {
        return app(PostEventsInterface::class)->getRelatedEvents($id, $limit);
    }
}

if (!function_exists('get_posts_by_category_events')) {
    /**
     * @param int $categoryId
     * @param int $paginate
     * @param int $limit
     * @return array
     */
    function get_posts_by_category_events($categoryId, $paginate = 12, $limit = 0)
    {
        return app(PostEventsInterface::class)->getByCategoryEvents($categoryId, $paginate, $limit);
    }
}

if (!function_exists('get_posts_by_tag')) {
    /**
     * @param string $slug
     * @param int $paginate
     * @return array
     */
    function get_posts_by_tag($slug, $paginate = 12)
    {
        return app(PostEventsInterface::class)->getByTag($slug, $paginate);
    }
}

if (!function_exists('get_posts_by_user')) {
    /**
     * @param $authorId
     * @param int $paginate
     * @return array
     */
    function get_posts_by_user($authorId, $paginate = 12)
    {
        return app(PostEventsInterface::class)->getByUserId($authorId, $paginate);
    }
}

if (!function_exists('get_all_post_events')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return array
     */
    function get_all_post_events($active = true, $perPage = 12)
    {
        return app(PostEventsInterface::class)->getAllPostEvents($perPage, $active);
    }
}

if (!function_exists('get_recent_posts_events')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_recent_posts_events($limit)
    {
        return app(PostEventsInterface::class)->getRecentPostEvents($limit);
    }
}

if (!function_exists('get_popular_posts_events')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return array
     */
    function get_popular_posts_events($limit = 10, array $args = [])
    {
        return app(PostEventsInterface::class)->getPopularPostEvents($limit, $args);
    }
}

if (!function_exists('get_relate_by_category_events')) {
    /**
     * @param int $categoryId
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_relate_by_category_events($id, $categoryId, $limit = 6)
    {
        return app(PostEventsInterface::class)->getRelatedByCategoryEvents($id, $categoryId, $limit);
    }
}

if (!function_exists('get_relate_post_by_category_events')) {
    /**
     * @param int $categoryId
     * @param int $limit
     * @return array
     */
    function get_relate_post_by_category_events($categoryId, $limit = 5)
    {
        return app(PostEventsInterface::class)->getRelatedPostByCategoryEvents($categoryId, $limit);
    }
}

