<?php
namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Platform\CategoryTraining\Models\CategoryTraining;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Platform\PostTraining\Models\PostTraining;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use SeoHelper;
use RvMedia;
use Throwable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class TrainingController extends Controller
{
    public function index_training(Request $request){
        $data = [];
        $page = [];
        SeoHelper::setTitle(@$page->name ?: __("Đào tạo tập huấn"), theme_option('site_title', ''), '|')
            ->setDescription(@$page->description ?: __("Đây là trang đào tạo tập huấn"), theme_option('seo_description'))
            ->openGraph()
            ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
            ->setUrl($request->url())
            ->addProperties(
                [
                    'image:width' => '1200',
                    'image:height' => '630'
                ]
            );
        $data = [
            'post_training' => get_all_post_training(6),
            'lasted_events' =>  get_featured_posts_events(2),
            'member'        => get_latest_post_associates(15),
        ];
        
        return view('theme.main::pages.trainings.list_training', $data);
    }

    public function detail_training
    (
        $slug, SlugInterface $slugRepository, 
        PostTrainingInterface $postTrainingInterface, 
        Request $request
        )
        {
        $slug = $slugRepository->getFirstBy(['key' => $slug, 'reference_type' => PostTraining::class]);
        if(!$slug){
            abort(404);
        }
        $training = $postTrainingInterface->getFirstBy(['id' => $slug->reference_id]);
        $data = [
            'name_category'   =>    get_category_by_post_training($training->id),
            'content'   =>  $postTrainingInterface->getFirstBy(['id' => $slug->reference_id],[],['categories_training']),
            'lasted_events'     =>  get_featured_posts_events(2),
            'lasted_events' =>  get_featured_posts_events(2),
            'member'        => get_latest_post_associates(15),
            'share_training'    =>  $request->url()
        ];
        if(!$data){
            abort(404);
        }

        SeoHelper::setTitle(@$data['content']->name ?: __("Đào tạo tập huấn"), theme_option('site_title', ''), '|')
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

        //dd($data['content']);
        return view('theme.main::pages.trainings.detail_training', $data);
    }

    public function category_training
    (
        $category_training= null, 
        PostTrainingInterface $postTrainingInterface, 
        Request $request, 
        CategoryTrainingInterface $categoryTrainingInterface,
        SlugInterface $slugRepository
        )
        {
        try{
            $slug = $slugRepository->getFirstBy(['key' => $category_training, 'reference_type' => CategoryTraining::class]);
            if (!$slug) {
                abort(404);
            }

            $category = $categoryTrainingInterface->getFirstBy(['id' => $slug->reference_id]);
            if (!$category) {
                abort(404);
            }
            SeoHelper::setTitle(@$category->name ?: __("Đào tạo tập huấn"), theme_option('site_title', ''), '|')
                ->setDescription(@$category->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );
        $data = [
            'lasted_posts' =>   get_latest_post_training(6),
            'all_posts'     =>  $postTrainingInterface->getByCategoryTraining($category->id, 6),
            'category'      =>  $category,
            'slug'          =>  $slug,
            'lasted_events' =>  get_featured_posts_events(2),
            'member'        => get_latest_post_associates(15),
        ];
        return view('theme.main::pages.trainings.list_training', $data);
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

    public function search_training(Request $request){

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
                PostTraining::class,
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