<?php
namespace Theme\Main\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MetaBox;
use Platform\Member\Models\Districts;
use Platform\Member\Models\Provinces;
use Platform\MemberOrganize\Models\MemberOrganize;
use Platform\MemberPersonal\Models\MemberPersonal;
use SeoHelper;
use RvMedia;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;
use Platform\Page\Models\Page;
use Platform\Base\Enums\BaseStatusEnum;
use Illuminate\Support\Facades\Log;
use Platform\CategoryAssociates\Models\CategoryAssociates;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Platform\PostAssociates\Models\PostAssociates;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Platform\Page\Repositories\Interfaces\PageInterface;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Symfony\Component\DependencyInjection\Reference;
use Theme\Main\Http\Requests\RegisterPersonalRequest;
use Theme\Main\Http\Requests\RegisterOrganizeRequest;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\Storage;

use Throwable;
use EmailHandler;

class AssociateController extends Controller
{
    public function index_associate(PostAssociatesInterface $postAssociatesInterface, Request $request)
    {
//        $data = [];
//        SeoHelper::setTitle(Str::upper('Danh sách hội viên'), theme_option('site_title', ''), '|')
//            ->setDescription(theme_option('seo_description'))
//            ->openGraph()
//            ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
//            ->setUrl($request->url())
//            ->addProperties(
//                [
//                    'image:width' => '1200',
//                    'image:height' => '630'
//                ]
//            );
//        return view('theme.main::pages.associate.member', $data);
    }

    public function category_associate($category, SlugInterface $slugRepository, CategoryAssociatesInterface $categoryAssociatesInterface, PostAssociatesInterface $postAssociatesInterface, Request $request){
        try{
            $data = [];
            $slug = $slugRepository->getFirstBy(['key' => $category, 'reference_type' => CategoryAssociates::class]);

            if(!$slug){
                abort ('404');
            }

            $category_associate = $categoryAssociatesInterface->getFirstBy(['id' => $slug->reference_id]);

            $meta = MetaBox::getMetaData($category_associate, 'seo_meta', true);

            $data = [
                'child' => $categoryAssociatesInterface->getAllChildrenAssociate($category_associate->id, ['post_associates']),
                'all_member'         =>  get_all_post_associates(4),
                'slug'               =>  $slug->key,
                'events_highlight'   => get_featured_posts_events(4),
                'category' => $category_associate,
            ];
            
            SeoHelper::setTitle(Str::upper($meta['seo_title'] ?: @$category_associate->name), theme_option('site_title', ''), '|')
                ->setDescription($meta['seo_description'] ?: @$category_associate->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );

            if(!$category_associate){
                abort ('404');
            }
            return view('theme.main::pages.associate.member', $data);
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
    public function register(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request){
        try {

            $slug = $slugRepository->getFirstBy(['key' => 'dang-ky-hoi-vien', 'reference_type' => Page::class]);
            $page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
            
			if (!$page) {
				abort(404);
            }
            
			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(Str::upper($meta['seo_title'] ?: @$page->name), theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
				->openGraph()
				->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
					[
						'image:width' => '1200',
						'image:height' => '630'
					]
                );
            $page_register = get_page_by_templates('register_member');
            $customfield = $page_register[0];
            $data = [
                'page' => $page,
                'lasted_events' => get_featured_posts_events(2),
                'custom_field' => $customfield,
                'member'        => get_latest_post_associates(15),
                'share_register' => $request->url(),
            ];

            
			return view('theme.main::pages.associate.register', $data);
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

    public function rule(SlugInterface $slugRepository, PageInterface $pageRepository, Request $request){
        try {
            $slug = $slugRepository->getFirstBy(['key' => 'quy-dinh-tro-thanh-hoi-vien', 'reference_type' => Page::class]);
            $page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

			if (!$page) {
				abort(404);
            }
            
			$meta = MetaBox::getMetaData($page, 'seo_meta', true);

			SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
				->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
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
                'page' => $page,
                'lasted_events' => get_featured_posts_events(2),
                'member'        => get_latest_post_associates(15),
                'share_rule'    =>  $request->url(),
            ];

            
			return view('theme.main::pages.associate.rule', $data);
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

    public function search_member(Request $request){
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
                    PostAssociates::class,
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

    public function getViewPersonal(PageInterface $pageRepository, SlugInterface $slugRepository, Request $request){
        try {
            $slug = $slugRepository->getFirstBy(['key' => 'dang-ky-hoi-vien-truc-tuyen', 'reference_type' => Page::class]);
            $page = $pageRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);

            if (!$page) {
                abort(404);
            }

            $meta = MetaBox::getMetaData($page, 'seo_meta', true);

            SeoHelper::setTitle(@$meta['seo_title'] ?: @$page->name, theme_option('site_title', ''), '|')
                ->setDescription(@$meta['seo_description'] ?: @$page->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );

            $provinces = Provinces::all();

            $data = [
                'page'      => $page,
                'provinces' => $provinces,
            ];

            return view('theme.main::pages.associate.contact_person', $data);

        }catch (Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
            return redirect()->back()->with(
                [
                    'type' => 'error',
                    'message' => $throwAble->getMessage()
                ]
            );
        }

    }

    public function getDistrictsInProvinceThuongTru(Request $request){
        if(!blank($request->pernament_main)){
            $provine = Provinces::where('name',  $request->pernament_main)->first();
            if($provine->id < 10){
                $id_province = '0' . $provine->id;
            }else{
                $id_province = $provine->id;
            }
            if($request->ajax()){
                $districts = Districts::where('province_id',  $id_province)->select('id', 'name')->get();
                return response()->json($districts);
            }
        }
    }

    public function getDistrictsInProvinceTamTru(Request $request){
        if(!blank($request->pernament_sub)){
            $provine = Provinces::where('name',  $request->pernament_sub)->first();
            if($provine->id < 10){
                $id_province = '0' . $provine->id;
            }else{
                $id_province = $provine->id;
            }
            if($request->ajax()){
                $districts = Districts::where('province_id',  $id_province)->select('id', 'name')->get();
                return response()->json($districts);
            }
        }
    }

    public function submitFormPersonal(RegisterPersonalRequest $request){
        try{
            $input = $request->all();
            if(!blank($request->file)){
                $file = $request->file;
                $input['file'] ='';
                $file_uploads = [];
                foreach($file as $k => $item){
                    $file_name = $item->getClientOriginalName();
                    $random_file_name = Str::random(4).'_'.$file_name;
                    while(file_exists('storage/register/'.$random_file_name)){
                        $random_file_name = Str::random(4).'_'.$file_name;
                    }
                    $load_file = RvMedia::handleUpload($item, 0, 'register');
                    $file_uploads[$k] = $load_file['data']->url;
                    $input['file'] = $input['file'].$random_file_name.', ';
                }
            }
            $request->purposes = json_encode($request->purposes);
            $input['purpose'] = $request->purposes;
            unset($input['purposes']);
            $data['input'] = $input;
            EmailHandler::send(view('theme.main::pages.associate.form_send_mail_personal', $data), 'Re: ' . 'Đăng ký hội viên trực tuyến', theme_option('mail_contact'), [
                'attachments' => [
                    public_path('storage/' . $file_uploads[0]),
                    public_path('storage/' . $file_uploads[1]),
                    public_path('storage/' . $file_uploads[2]),
                    public_path('storage/' . $file_uploads[3]),
                    public_path('storage/' . $file_uploads[4]),
                    public_path('storage/' . $file_uploads[5]),
                    public_path('storage/' . $file_uploads[6]),
                ]
                ], true);
            MemberPersonal::create($input);

            return redirect()->back()->with(['msg'=>__('Gửi thông tin thành công'),'type'=>'success']);
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

    public function submitFormOrganize(RegisterOrganizeRequest $request){
        try{
            $input = $request->all();
            if(!blank($request->file)){
                $file = $request->file;
                $input['file'] ='';
                $file_uploads = [];
                foreach($file as $k => $item){
                    $file_name = $item->getClientOriginalName();
                    $random_file_name = Str::random(4).'_'.$file_name;
                    while(file_exists('storage/register/'.$random_file_name)){
                        $random_file_name = Str::random(4).'_'.$file_name;
                    }
                    $load_file = RvMedia::handleUpload($item, 0, 'register');
                    $file_uploads[$k] = $load_file['data']->url;
                    $input['file'] = $input['file'].$random_file_name.', ';
                }
                

                $request->activity_for_latest_years = json_encode($request->activity_for_latest_years);
                $input['activity_for_latest_years'] = $request->activity_for_latest_years;
                $request->activity = json_encode($request->activity);
                $input['activity'] = $request->activity;
                $request->purpose = json_encode($request->purpose);
                $input['purpose'] = $request->purpose;
                $data['input'] = $input;
                
    
                EmailHandler::send(view('theme.main::pages.associate.form_send_mail', $data), 'Re: ' . 'Đăng ký hội viên trực tuyến', theme_option('mail_contact'), [
                    'attachments' => [
                        public_path('storage/' . $file_uploads[0]),
                        public_path('storage/' . $file_uploads[1]),
                        public_path('storage/' . $file_uploads[2]),
                        public_path('storage/' . $file_uploads[3]),
                        public_path('storage/' . $file_uploads[4]),
                        public_path('storage/' . $file_uploads[5]),
                        public_path('storage/' . $file_uploads[6]),
                        public_path('storage/' . $file_uploads[7]),
                        public_path('storage/' . $file_uploads[8]),
                        public_path('storage/' . $file_uploads[9]),
                    ]
                    ], true);
                
                MemberOrganize::create($input);
    
                return redirect()->back()->with(['msg'=>__('Gửi thông tin thành công'),'type'=>'success']);
            }

        }catch(Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage(), $throwAble->getLine()]);
            dd($throwAble->getMessage());
            return redirect()->back()->with(
                [
                    'type' => 'error',
                    'message' => $throwAble->getMessage(),
                    'line'  => $throwAble->getLine(),
                ]
            );
        }

    }
}