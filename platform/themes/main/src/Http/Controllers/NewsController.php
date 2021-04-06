<?php
namespace Theme\Main\Http\Controllers;

use Illuminate\Routing\Controller;
use SeoHelper;
use RvMedia;
use Illuminate\Support\Str;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Blog\Models\Post;
use Platform\Blog\Repositories\Interfaces\PostInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Platform\Blog\Models\Category;
use Platform\Blog\Repositories\Interfaces\CategoryInterface;
use Platform\Support\Http\Requests\Request as PlatformRequest;
use Platform\Support\Http\Requests\Request as PlatformSupportRequest;
use Throwable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class NewsController extends Controller
{

    public function index(PostInterface $postInterface, Request $request)
    {
        $page = [];
        $data = [];
        SeoHelper::setTitle(@$page->name ?: __("Tin tức"), theme_option('site_title', ''), '|')
            ->setDescription(@$page->description ?: __("Đây là trang tin tức"), theme_option('seo_description'))
            ->openGraph()
            ->setUrl($request->url())
            ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
            );
        $data['member'] = get_latest_post_associates(15);
        $data['lasted_posts'] = get_latest_posts(6);
        $data['lasted_events'] = get_featured_posts_events(2);
        $data['new_post'] =  get_featured_posts(5);
        $data['posts'] = $postInterface->getAllPosts(6);
        $data['events_highlight'] = get_featured_posts_events(4);    
        return  view('theme.main::pages.posts.total_news', $data);
    }

    public function detail_news(
        $slug, SlugInterface $slugRepository, 
        PostInterface $postInterface, 
        CategoryInterface $categoryInterface,
        Request $request
    )
    {
        $data = [];
        $slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => Post::class]);
        if (!$slug) {
            abort(404);
        }
        $data['share_new'] = $request->url();
        $data['post'] = $postInterface->getFirstBy(['id' => $slug->reference_id]);
        $data['category'] = get_category_by_post($data['post']->id);
        $data['member'] = get_latest_post_associates(15);
        $data['lasted_events'] = get_featured_posts_events(2);
        $data['content'] = $postInterface->getFirstBy(['id' => $slug->reference_id]);
        $data['posts_by_cat'] = $postInterface->getRelatedByCategory($slug->reference_id, $data['content']->categories[0]->id);
        $data['events_highlight'] = get_featured_posts_events(4);
        if (!$data) {
            abort(404);
        }

        SeoHelper::setTitle(@$data['content']->name ?: __("Tin tức"), theme_option('site_title', ''), '|')
                ->setDescription(@$data['content']->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setUrl($request->url())
                ->setImage(RvMedia::getImageUrl(@$data['content']->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );

        return view('theme.main::pages.posts.detail_post', $data);
    }

    public function category(
        $category = null, 
        Request $request, 
        PostInterface $postInterface, 
        SlugInterface $slugRepository, 
        CategoryInterface $categoryInterface
        )
        {
        try{
            $page = [];
            $data = [];
            $slug = $slugRepository->getFirstBy(['key' => $category, 'reference_type' => Category::class]);
            if (!$slug) {
                abort(404);
            }
            $data['member'] = get_latest_post_associates(15);
            $data['lasted_events'] = get_featured_posts_events(2);
            $data['lasted_posts'] = get_latest_posts(6);
            $data['category'] = $categoryInterface->getFirstBy(['id' => $slug->reference_id]); 
            $data['child_cats'] = $categoryInterface->getAllChildren($data['category']->id, ['posts']);
            $data['new_post'] =  get_featured_posts(5);
            $data['featured_post'] = get_relate_post_by_category($data['category']->id, 6);
            $data['post_no_perpage']    =   $postInterface->getByCategoryNoPerPage($data['category']->id, 5);
            $data['posts']  =   $postInterface->getByCategory($data['category']->id, 5);
            $data['events_highlight'] = get_featured_posts_events(4);
            $data['slug'] = $slug;

            SeoHelper::setTitle(@$data['category']->name ?: __("Tin tức"), theme_option('site_title', ''), '|')
                ->setDescription(@$data['category']->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setUrl($request->url())
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );

            if (!$data) {
                abort(404);
            }
            if(!count($data['child_cats'])){
                return view('theme.main::pages.posts.list_post', $data);
            }else{
                
                return  view('theme.main::pages.posts.tutorial_news', $data);
            }
        }catch(Throwable $e){
            report($e);
            return false;
        }
    }

    public function search_news(Request $request){

        $page = [];
        SeoHelper::setTitle(@$page->name ?: __("Tìm kiếm"), theme_option('site_title', ''), '|')
            ->setDescription(@$page->description ?: theme_option('seo_description'))
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
                        ->addSearchableAttribute('description')
                        ->addSearchableAttribute('name');
                }
            )
            ->search($key);
            $endtime = microtime(true);
            $time = round($endtime - $starttime, 5);
            return view('theme.main::views.form_search', compact('search_result', 'key', 'time'));
    }
}