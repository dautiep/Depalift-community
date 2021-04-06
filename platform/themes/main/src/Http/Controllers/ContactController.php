<?php

namespace Theme\Main\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Platform\Contact\Models\Contact;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;
use Platform\Page\Models\Page;
use EmailHandler;
use SlugHelper;
use Countable;
use Mail;
use SeoHelper;
use RvMedia;
use MetaBox;
use PhpParser\Node\Stmt\TryCatch;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try{
            $data = [];
            $data['page'] = SlugHelper::getSlug('lien-he', null, Page::class)->reference ?? null;
            $meta = MetaBox::getMetaData($data['page'], 'seo_meta', true);
    
            SeoHelper::setTitle(Str::upper($meta['seo_title'] ?: @$data['page']->name), theme_option('site_title', ''), '|')
                ->setDescription($meta['seo_description'] ?: @$data['page']->description ?: theme_option('seo_description'))
                ->openGraph()
                ->setImage(RvMedia::getImageUrl(theme_option('header_logo'), 'og', false, RvMedia::getImageUrl(theme_option('seo_og_image'))))
                ->setUrl($request->url())
                ->addProperties(
                    [
                        'image:width' => '1200',
                        'image:height' => '630'
                    ]
                );
    
            $page_contact = get_page_by_templates('contact');
            $data['custom_field'] = $page_contact[0];
            return  view('theme.main::pages.contacts.contact', $data);

        }catch(Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
            return abort(404);
        }
       
    }

    public function faq(Request $request)
    {
        try{
            $data = [];
            $data['page'] = SlugHelper::getSlug('faq', null, Page::class)->reference ?? null;
            $meta = MetaBox::getMetaData($data['page'], 'seo_meta', true);
            SeoHelper::setTitle(Str::upper($meta['seo_title'] ?: @$data['page']->name), theme_option('site_title', ''), '|')
                ->setDescription($meta['seo_description'] ?: @$data['page']->description ?: theme_option('seo_description'))
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
            $data['lasted_events'] = get_featured_posts_events(2);
            $page_contact = get_page_by_templates('faq');
            $data['custom_field'] = $page_contact[0];
            return  view('theme.main::pages.contacts.faq', $data);

        }catch(Throwable $throwAble){
            Log::error('Có lỗi xảy ra thực hiện chức năng '.__CLASS__.'@'.__FUNCTION__, [$throwAble->getMessage()]);
            return abort(404);
        }
    }

    public function submit_contacts(Request $request){

        $input = $request->all();
        $data['input'] = $input;
        $data['url'] = $request->url();
        $request->validate([
            'name' => 'required',
            'company'=>'required',
            'number_company'=>'required',
            'address'=>'required',
            'email' => ['required', 'email:rfc,dns'],
            'phone' => ['required', 'numeric'],
            'problem' => 'required',
            'content'=>'required',
        ],[
            'name.required' =>  __('Vui lòng nhập tên của bạn!'),
            'company.required' =>  __('Vui lòng nhập tên doanh nghiệp!'),
            'number_company.required' =>  __('Vui lòng nhập mã số doanh nghiệp!'),
            'address.required' =>  __('Vui lòng nhập địa chỉ!'),
            'email.required' =>  __('Vui lòng nhập email!'),
            'phone.required' =>  __('Vui lòng nhập số điện thoại!'),
            'problem.required' =>  __('Vui lòng nhập tích vào vấn đề cần giúp đỡ!'),
            'content.required' =>  __('Vui lòng nhập nội dung!'),
            'phone.numeric'    =>__('Số điện thoại phải là số'),
            'email.email'     => __('Vui lòng nhập đúng định dạng file'),
            ]);
            
            if($request->hasFile('file')){
                $file = $request->file;
                $file_extension = $file->getClientOriginalExtension(); //lay duoi file
                if($file_extension == 'docs' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'xlsm' || $file_extension == 'pdf'){
                    
                }
                else
                return redirect()->back()->with(['msg'=>__('Hệ thống chưa hổ trợ file vừa Upload. Vui lòng chọn lại file'),'type'=>'warning']);
                $file_name = $file->getClientOriginalName();
                $random_file_name = Str::random(4).'_'.$file_name;
                while(file_exists('storage/contacts/'.$random_file_name)){
                    $random_file_name = Str::random(4).'_'.$file_name; 
                }
                RvMedia::handleUpload($input['file'], 0, 'contacts');
                $input['file'] = $random_file_name;
                Contact::create($input);
            }
            EmailHandler::send(view('theme.main::pages.contacts.form_receive', $data), 'Re: ' . $request->subject, $request->email);
            EmailHandler::send(view('theme.main::pages.contacts.form_send_mail', $data), 'Re: ' . $request->subject, 'contact@vnea.com.vn');
            $contact = Contact::create($input);
            return redirect()->back()->with(['msg'=>__('Gửi thông tin thành công'),'type'=>'success']);
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
                        ->addSearchableAttribute('description')
                        ->addExactSearchableAttribute('name');
                }
            )
            ->registerModel(
                PostEvents::class,
                function(ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('description')
                    ->addExactSearchableAttribute('name');
                }
            )
            ->registerModel(
                PostTraining::class,
                function(ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('description')
                    ->addExactSearchableAttribute('name');
                }
            )
            ->registerModel(
                PostAssociates::class,
                function(ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addExactSearchableAttribute('name');
                }
            )
            ->registerModel(
                PostProducer::class,
                function(ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('description')
                    ->addExactSearchableAttribute('name');  
                }
            )
            ->registerModel(
                LibraryDocument::class,
                function(ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('description')
                    ->addExactSearchableAttribute('name');
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

}