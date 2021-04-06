<?php 

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Supports\SortItemsWithChildrenHelper;
use Illuminate\Support\Arr;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;

if (!function_exists('get_featured_posts_producer')) {
    /**
     * @param int $limit
     * @param array $with
     * @return array
     */
    function get_featured_posts_producer($limit, array $with = [])
    {
        return app(PostProducerInterface::class)->getFeaturedproducer($limit, $with);
    }
}

if (!function_exists('get_latest_post_producer')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_post_producer($limit, $excepts = [])
    {
        return app(PostProducerInterface::class)->getListPostProducerNonInList($excepts, $limit);
    }
}

if (!function_exists('get_related_posts_producer')) {
    /**
     * @param int $id
     * @param int $limit
     * @return array
     */
    function get_related_posts_producer($id, $limit)
    {
        return app(PostProducerInterface::class)->getRelatedProducer($id, $limit);
    }
}

if (!function_exists('get_posts_by_user_producer')) {
    /**
     * @param $authorId
     * @param int $paginate
     * @return array
     */
    function get_posts_by_user_producer($authorId, $paginate = 12)
    {
        return app(PostProducerInterface::class)->getByUserIdProducer($authorId, $paginate);
    }
}

if (!function_exists('get_all_post_producer')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return array
     */
    function get_all_post_producer($active = true, $perPage = 12)
    {
        return app(PostProducerInterface::class)->getAllPostProducer($perPage, $active);
    }
}

// if (!function_exists('get_recent_posts_events')) {
//     /**
//      * @param int $limit
//      * @return array
//      */
//     function get_recent_posts_events($limit)
//     {
//         return app(PostEventsInterface::class)->getRecentPostEvents($limit);
//     }
// }

if (!function_exists('get_popular_posts_producer')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return array
     */
    function get_popular_posts_producer($limit = 10, array $args = [])
    {
        return app(PostProducerInterface::class)->getPopularPostProducer($limit, $args);
    }
}
