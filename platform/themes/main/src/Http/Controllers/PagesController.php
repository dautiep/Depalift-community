<?php

namespace Theme\Main\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use MetaBox;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Page\Models\Page;
use Platform\Page\Repositories\Interfaces\PageInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Http\Request;
use RvMedia;
use SeoHelper;
use Theme;
use Throwable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PagesController extends Controller
{


	public function index(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request)
	{
		try {
			$data = [];

			$slug = $slugRepository->getFirstBy(['key' => 'gioi-thieu-hiep-hoi', 'reference_type' => Page::class]);

			$page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

			if (!$page) {
				abort(404);
			}

			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(@$page->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);

			$data['share_introduce'] = $request->url();
			$data['page'] = $page;
			$data['lasted_events'] = get_featured_posts_events(2);
			$data['member'] = get_latest_post_associates(15);

			return view('theme.main::pages.introduce.introduce_the_association', $data);
		} catch (Throwable $throwAble) {
			Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
			return redirect()->back()->with(
				[
					'type' => 'error',
					'message' => $throwAble->getMessage()
				]
			);
		}
	}


	public function operatingCharter(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request)
	{
		try {
			$data = [];

			$slug = $slugRepository->getFirstBy(['key' => 'dieu-le-hoat-dong', 'reference_type' => Page::class]);

			$page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

			if (!$page) {
				abort(404);
			}

			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(@$page->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);
			
			$data['share_charter'] = $request->url();
			$data['page'] = $page;
			$data['lasted_events'] = get_featured_posts_events(2);
			$data['member'] = get_latest_post_associates(15);

			return view('theme.main::pages.introduce.operating_charter', $data);
		} catch (Throwable $throwAble) {
			Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
			return redirect()->back()->with(
				[
					'type' => 'error',
					'message' => $throwAble->getMessage()
				]
			);
		}
	}


	public function directionOfOperation(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request)
	{
		try {
			$data = [];

			$slug = $slugRepository->getFirstBy(['key' => 'phuong-huong-hoat-dong', 'reference_type' => Page::class]);

			$page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

			if (!$page) {
				abort(404);
			}

			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(@$page->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);
			
			$data['share_direction'] = $request->url();
			$data['page'] = $page;
			$data['lasted_events'] = get_featured_posts_events(2);
			$data['member'] = get_latest_post_associates(15);

			return view('theme.main::pages.introduce.direction_of_operation', $data);
		} catch (Throwable $throwAble) {
			Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
			return redirect()->back()->with(
				[
					'type' => 'error',
					'message' => $throwAble->getMessage()
				]
			);
		}
	}


	public function organizationalStructure(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request)
	{
		try {
			$data = [];

			$slug = $slugRepository->getFirstBy(['key' => 'co-cau-to-chuc', 'reference_type' => Page::class]);

			$page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

			if (!$page) {
				abort(404);
			}

			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(@$page->image, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);

			$data['share_structure'] = $request->url();
			$data['page'] = $page;
			$data['lasted_events'] = get_featured_posts_events(2);
			$data['member'] = get_latest_post_associates(15);

			return view('theme.main::pages.introduce.organizational_structure', $data);

		} catch (Throwable $throwAble) {
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
    public function getViewSearch(Request $request)
    {

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
        ->registerModel(
            PostEvents::class,
            function(ModelSearchAspect $modelSearchAspect){
                $modelSearchAspect
                ->addSearchableAttribute('description')
                ->addSearchableAttribute('name');
            }
        )
        ->registerModel(
            PostTraining::class,
            function(ModelSearchAspect $modelSearchAspect){
                $modelSearchAspect
                ->addSearchableAttribute('description')
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
                ->addSearchableAttribute('description')
                ->addSearchableAttribute('name');  
            }
        )
        ->registerModel(
            LibraryDocument::class,
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