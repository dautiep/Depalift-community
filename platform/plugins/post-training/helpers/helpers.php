<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_posts_training')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_posts_training($limit, array $with = [])
    {
        return app(PostTrainingInterface::class)->getFeatured_training($limit, $with);
    }
}

if (!function_exists('get_latest_post_training')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_post_training($limit, $excepts = [])
    {
        return app(PostTrainingInterface::class)->getListPostTrainingNonInList($excepts, $limit);
    }
}

if (!function_exists('get_related_posts_training')) {
    /**
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_related_posts_training($id, $limit)
    {
        return app(PostTrainingInterface::class)->getRelatedTraining($id, $limit);
    }
}

if (!function_exists('get_posts_by_category_training')) {
    /**
     * @param int $categoryId
     * @param int $paginate
     * @param int $limit
     * @return array
     */
    function get_posts_by_category_training($categoryId, $paginate = 12, $limit = 0)
    {
        return app(PostTrainingInterface::class)->getByCategoryTraining($categoryId, $paginate, $limit);
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
//         return app(PostEventsInterface::class)->getByTag($slug, $paginate);
//     }
// }

if (!function_exists('get_posts_by_user_training')) {
    /**
     * @param $authorId
     * @param int $paginate
     * @return array
     */
    function get_posts_by_user_training($authorId, $paginate = 12)
    {
        return app(PostTrainingInterface::class)->getByUserIdTraining($authorId, $paginate);
    }
}

if (!function_exists('get_all_post_training')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return array
     */
    function get_all_post_training($active = true, $perPage = 12)
    {
        return app(PostTrainingInterface::class)->getAllPostTraining($perPage, $active);
    }
}

if (!function_exists('get_recent_posts_training')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_recent_posts_training($limit)
    {
        return app(PostTrainingInterface::class)->getRecentPostTraining($limit);
    }
}

if (!function_exists('get_popular_posts_training')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return array
     */
    function get_popular_posts_training($limit = 10, array $args = [])
    {
        return app(PostTrainingInterface::class)->getPopularPostTraining($limit, $args);
    }
}

if (!function_exists('get_relate_by_category_training')) {
    /**
     * @param int $categoryId
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_relate_by_category_training($id, $categoryId, $limit = 6)
    {
        return app(PostTrainingInterface::class)->getRelatedByCategoryTraining($id, $categoryId, $limit);
    }
}