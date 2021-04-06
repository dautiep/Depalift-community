<?php
namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SeoHelper;
use RvMedia;
use Throwable;
use Illuminate\Support\Facades\Log;
use Platform\PostProducer\Models\PostProducer;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class ProducerController extends Controller
{
    public function index(Request $request){
        try{
            $page = [];
            $data = [
                'all_post' => get_all_post_producer(3),
                'lasted_events' => get_featured_posts_events(2),
                'member'        =>  get_latest_post_associates(15),
            ];
            SeoHelper::setTitle(@$page->name ?: __("NSX và cung cấp vật tư"), theme_option('site_title', ''), '|')
            ->setDescription(@$page->description ?: __("Đây là NSX và cung cấp vật tư"), theme_option('seo_description'))
            ->openGraph()
            ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->setUrl($request->url())
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
            );
            return view('theme.main::pages.producers.list_producer', $data);
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

    public function detail(
        $slug, SlugInterface $slugRepository, 
        PostProducerInterface $postProducerInterface, 
        Request $request
        )
        {
        $data = [];
        $slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => PostProducer::class]);
        if (!$slug) {
            abort(404);
        }
        $data['member'] = get_latest_post_associates(15);
        $data['lasted_events'] = get_featured_posts_events(2);
        $data['content'] = $postProducerInterface->getFirstBy(['id' => $slug->reference_id]);
        $data['share_producer'] =   $request->url();
        SeoHelper::setTitle(@$data['content']->name ?: __("NSX và cung cấp vật tư"), theme_option('site_title', ''), '|')
            ->setDescription(@$data['content']->description ?: theme_option('seo_description'))
            ->openGraph()
            ->setImage(RvMedia::getImageUrl($data['content']->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->setUrl($request->url())
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
            );
        return view('theme.main::pages.producers.detail_producer', $data);
    }

    public function search_producer(Request $request){

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
                PostProducer::class,
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