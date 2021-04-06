<?php


namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use MetaBox;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\LibraryCategory\Models\LibraryCategory;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;
use Platform\LibraryDocument\Models\LibraryDocument;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use RvMedia;
use SeoHelper;
use Throwable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class LibraryController extends Controller
{

	public function detail(
		$slug, SlugInterface $slugInterface, 
		LibraryDocumentInterface $libraryDocumentInterface,
		LibraryCategoryInterface $libraryCategoryInterface,
		Request $request)
	{
		try {
			$data = [];

			$slug = $slugInterface->getFirstBy(['key' => $slug, 'reference_type' => LibraryDocument::class]);
			if (!$slug) {
				abort(404);
			}
			$post = $libraryDocumentInterface->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
			if (!$post) {
				abort(404);
			}
			$meta = MetaBox::getMetaData($post, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$post->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$post->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(@$post->thumbnail, 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);
			
			$data['share_doc']	= $request->url();
			$data['lasted_events'] = get_featured_posts_events(2);
			$data['post'] = $post;
			$data['member'] = get_latest_post_associates(15);
			$data['id_category'] = $libraryCategoryInterface->getCategoryByDoc($post->id);
			$data['post_doc']	= 	$libraryDocumentInterface->getRelatedByCategoryDoc($post->id, $data['id_category'][0]->id);

			return view('theme.main::pages.libraries.detail_library', $data);
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

	public function category($category, SlugInterface $slugInterface, 
	LibraryCategoryInterface $libraryCategoryInterface,
	LibraryDocumentInterface $libraryDocumentInterface,
	Request $request)
	{
		try {
			$data = [];

			$slug = $slugInterface->getFirstBy(['key' => $category, 'reference_type' => LibraryCategory::class]);
			if (!$slug) {
				abort(404);
			}

			$category = $libraryCategoryInterface->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED], ['*'], ['documents']);
			if (!$category) {
				abort(404);
			}
			$meta = MetaBox::getMetaData($category, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$category->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$category->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
				->setUrl($request->url())
				->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
				);
			$data['category'] = $category;
			$data['category_library'] = $libraryDocumentInterface->getByCategoryLibrary($category->id, 6);
			
			$data['member'] = get_latest_post_associates(15);
			$data['lasted_events'] = get_featured_posts_events(2);

			return view('theme.main::pages.libraries.category', $data);
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

	public function search_library(Request $request){

		$page = [];
        SeoHelper::setTitle(@$page->name ?: __("Tìm kiếm"), theme_option('site_title', ''), '|')
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