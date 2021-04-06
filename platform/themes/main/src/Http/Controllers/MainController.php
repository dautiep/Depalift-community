<?php

namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\Blog\Models\Post;
use Platform\LibraryDocument\Models\LibraryDocument;
use Platform\Page\Models\Page;
use Platform\Page\Repositories\Eloquent\PageRepository;
use Platform\Page\Repositories\Interfaces\PageInterface;
use Platform\PostAssociates\Models\PostAssociates;
use Platform\PostEvents\Models\PostEvents;
use Platform\PostProducer\Models\PostProducer;
use Platform\PostTraining\Models\PostTraining;
use Platform\Theme\Http\Controllers\PublicController;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Illuminate\Support\Str;

use SlugHelper;
use MetaBox;
use SeoHelper;
use RvMedia;
use Throwable;

class MainController extends PublicController
{
    /**
     * @return \Illuminate\Http\Response|Response
     */
    public function getIndex(BaseHttpResponse $response)
    {
        try{
            $page = [];
            $data['page'] = SlugHelper::getSlug('trang-chu', null, Page::class)->reference ?? null;

            $meta = MetaBox::getMetaData($data['page'], 'seo_meta', true);

            SeoHelper::setTitle(Str::upper($meta['seo_title'] ?: @$data['page']->name), theme_option('site_title', ''), '|')
                ->setDescription($meta['seo_description'] ?: @$data['page']->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );
            //end SEO

            $cats= get_categories_with_children([],['posts']);
            //merge child category
            $alpha = array();
            foreach($cats as $value){
                $text[] = array_merge($alpha, $value['child_cats']);
            }
            $merge_cats= [];
            foreach($text as $k => $v){
                $merge_cats= array_merge($merge_cats, $text[$k]);
            }
            $page = get_page_by_templates('homepage');
            $customfield = $page[0];

            //get event (challenge)
            $events = array_reverse(get_category_events_with_children([], ['posts_events_desc'], []));
            //dd($events[2]->child_cats[0]);
            $data = [
                'cats' => $merge_cats,
                'lasted_posts' => get_latest_posts(6),
                'lasted_events' => get_featured_posts_events(2),
                'new_post' => get_featured_posts(5),
                'all_post_events' => get_latest_post_events(5),
                'events' => $events,
                'all_post_training' => get_latest_post_training(5),
                'custom_field' => $customfield,
                'member'        => get_latest_post_associates(15),
                'page' => $page,
            ];

            return view('theme.main::views.index', $data);
        }catch(Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
            return abort(404);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getViewSearch(Request $request)
    {
        try{
            SeoHelper::setTitle(Str::upper('Tìm kiếm'), theme_option('site_title', ''), '|')
                ->setDescription(theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );
            $starttime = microtime(true);
            $key = $request['q'];
            $search_result = (new Search())
                ->registerModel(
                    Post::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->registerModel(
                    PostEvents::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->registerModel(
                    PostTraining::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->registerModel(
                    PostAssociates::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->registerModel(
                    PostProducer::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->registerModel(
                    LibraryDocument::class,
                    function(ModelSearchAspect $modelSearchAspect){
                        $modelSearchAspect
                            ->addSearchableAttribute('name');
                    }
                )
                ->search($key);
            $endtime = microtime(true);
            $time = round($endtime - $starttime, 5);

            return view('theme.main::views.form_search', compact('search_result', 'key', 'time'));
        }catch(Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
            return redirect()->back()->with(
                [
                    'type' => 'error',
                    'message' => $throwAble->getMessage()
                ]
            );
        }

    }

    /**
     * {@inheritDoc}
     */
    public function getSiteMap()
    {
        return parent::getSiteMap();
    }
}