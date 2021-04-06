<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_post_associates')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_post_associates($limit, array $with = [])
    {
        return app(PostAssociatesInterface::class)->getFeatured_Associates($limit, $with);
    }
}

if (!function_exists('get_latest_post_associates')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_post_associates($limit, $excepts = [])
    {
        return app(PostAssociatesInterface::class)->getListPostAssociatesNonInList($excepts, $limit);
    }
}

if (!function_exists('get_related_post_associates')) {
    /**
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_related_post_associates($id, $limit)
    {
        return app(PostAssociatesInterface::class)->getRelatedAssociates($id, $limit);
    }
}

if (!function_exists('get_post_associates_by_category')) {
    /**
     * @param int $categoryId
     * @param int $paginate
     * @param int $limit
     * @return array
     */
    function get_post_associates_by_category($categoryId, $paginate = 12, $limit = 0)
    {
        return app(PostAssociatesInterface::class)->getByCategoryAssociates($categoryId, $paginate, $limit);
    }
}

// if (!function_exists('get_posts_by_tag')) {
//     /**
//      * @param string $slug
//      * @param int $paginate
//      * @return array
//      */
//     function get_posts_by_tag($slug, $paginate = 12)
//     {
//         return app(PostAssociatesInterface::class)->getByTag($slug, $paginate);
//     }
// }

if (!function_exists('get_post_associates_by_user')) {
    /**
     * @param $authorId
     * @param int $paginate
     * @return array
     */
    function get_post_associates_by_user($authorId, $paginate = 12)
    {
        return app(PostAssociatesInterface::class)->getByUserIdAssociates($authorId, $paginate);
    }
}

if (!function_exists('get_all_post_associates')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return array
     */
    function get_all_post_associates($active = true, $perPage = 12)
    {
        return app(PostAssociatesInterface::class)->getAllPostAssociates($perPage, $active);
    }
}

if (!function_exists('get_recent_post_associates')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_recent_post_associates($limit)
    {
        return app(PostAssociatesInterface::class)->getRecentPostAssociates($limit);
    }
}

if (!function_exists('get_popular_post_associates')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return array
     */
    function get_popular_post_associates($limit = 10, array $args = [])
    {
        return app(PostAssociatesInterface::class)->getPopularPostAssociates($limit, $args);
    }
}