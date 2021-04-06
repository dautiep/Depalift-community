<?php
namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use SeoHelper;
use RvMedia;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\PostEvents\Models\PostEvents;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Platform\CategoryEvents\Models\CategoryEvents;
use Throwable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class EventsController extends Controller
{
    public function index(
        Request $request, 
        PostEventsInterface $postEventsInterface, 
        CategoryEventsInterface $categoryEventsInterface
    )
    {   
        $page = [];
        $data = [];
        SeoHelper::setTitle(@$page->name ?: __("Sự kiện"), theme_option('site_title', ''), '|')
            ->setDescription(@$page->description ?: __("Đây là trang sự kiện"), theme_option('seo_description'))
            ->openGraph()
            ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->setUrl($request->url())
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
            );

        $data['member'] = get_latest_post_associates(15);
        $data['news_events'] = $postEventsInterface->getAllPostEventsNoPerPage(5);
        $data['featured_events'] =  get_featured_posts_events(6);
        $data['all_posts_events'] = $postEventsInterface->getAllPostEvents(6); 
        
        return view('theme.main::pages.events.events_total', $data);
    }

    public function detail(
        $slug, SlugInterface $slugRepository, 
        PostEventsInterface $postEventsInterface, 
        Request $request
    )
    {
        $slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => PostEvents::class]);
        
        if (!$slug) {
            abort(404);
        }
        $data['share']  = $request->url();
        $data['events'] = $postEventsInterface->getFirstBy(['id' => $slug->reference_id]);
        $data['name_category'] = get_category_by_post_events($data['events']->id);
        $data['member'] = get_latest_post_associates(15);
        $data['lasted_events'] = get_featured_posts_events(2);
        $data['content'] = $postEventsInterface->getFirstBy(['id' => $slug->reference_id],[],['categories_events']);
        $data['posts_by_cat'] = $postEventsInterface->getRelatedByCategoryEvents($slug->reference_id, $data['content']->categories_events[0]->id);
        if (!$data) {
            abort(404);
        }
        SeoHelper::setTitle(@$data['content']->name ?: __("Sự kiện"), theme_option('site_title', ''), '|')
            ->setDescription(@$data['content']->description ?: theme_option('seo_description'))
            ->openGraph()
            ->setImage(RvMedia::getImageUrl(@$data['content']->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->setUrl($request->url())
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
        );
        return view('theme.main::pages.events.detail_events', $data);
    }

    public function category(
        $category = null, 
        Request $request, 
        PostEventsInterface $postEventsInterface, 
        SlugInterface $slugRepository, 
        CategoryEventsInterface $categoryEventsInterface
    )
    {
        try{
            $slug = $slugRepository->getFirstBy(['key' => $category, 'reference_type' => CategoryEvents::class]);
            if (!$slug) {
                abort(404);
            }
            $category_events = $categoryEventsInterface->getFirstBy(['id' => $slug->reference_id]);
            
            if (!$category_events) {
                abort(404);
            }
            SeoHelper::setTitle(@$category_events->name ?: __("Sự kiện"), theme_option('site_title', ''), '|')
                ->setDescription(@$category_events->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );
            $data['member'] = get_latest_post_associates(15);
            $data['news_events'] = $postEventsInterface->getAllPostEventsNoPerPage(5); 
            $data['featured_events'] =  get_featured_posts_events(6);
            $data['category'] = $category_events;
            $data['slug'] = $slug;
            $data['featured_post_events'] = get_relate_post_by_category_events($data['category']->id, 6);
            $data['lasted_posts'] = get_latest_posts(6);
            $data['all_posts'] = $postEventsInterface->getByCategoryEvents($data['category']->id, 6);
            $data['all_posts_events'] = $postEventsInterface->getByCategoryEventsNoPerPage($data['category']->id, 5);
            $data['child'] = $categoryEventsInterface->getAllChildrenEvents($data['category']->id, ['posts_events']);
        if(!count($data['child'])){ 
            return view('theme.main::pages.events.list_events', $data);
        }else{
            return view('theme.main::pages.events.total_events', $data);
        }
            
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

    public function search(Request $request){

        $page = [];
        SeoHelper::setTitle(Str::upper('Tìm kiếm'), theme_option('site_title', ''), '|')
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
                PostEvents::class,
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