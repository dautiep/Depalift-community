@extends('theme.main::layouts.default')
@section('content')
<div class="container">
    <section class="row">
        <section class="header-bottom mrt5 mrb10 w-100">
            <div class="form-inline">
                <div class="col-md-9 hidden-sm-down">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-sub-main">
                            <a href="{{route('public.index')}}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="javascript:void(0)">
                                <i class="fas fa-angle-right"></i>
                                {{__("Thư viện")}}
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            @if (count($id_category))   
                                <a href="{{route('libraries.index', $id_category[0]->slug)}}">
                                    <i class="fas fa-angle-right"></i>
                                    {{$id_category[0]->description}}
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('search_library')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('search_library')}}">
                                    <i class="fas fa-search icon__search"></i>
                                </a>
                            </button>
                        </div>
                        <span class="btn-search __js_show_search" id="menu-search">{{__("Tìm kiếm")}}
                            <i class="fas fa-search button-search"></i>
                        </span>
                    </form>
                </div>
            </div>
        </section>
    </section>
</div>
<section class="container">
    <section class="row">
        <div class="col-md-8">
            <section class="news-detail">
                <h1 class="news-detail-title">{{$post->name}}</h1>
                <time class="news-detail-time">
                    <i class="fas fa-calendar"></i>
                    {{date_format($post->created_at,"d/m/yy")}}
                </time>
                <div class="news-detail-content">
                    @php echo $post->description @endphp
                </div>
                <br>
                @if ($id_category[0]->name == 'Văn bản')
                    {{-- @foreach(get_field($post, 'file_attachments')  as $item)
                        <a class="register_member text-danger" href="{{ asset('storage/' .get_sub_field($item, 'attachment_file')) }}" download="{{get_sub_field($item, 'file_name')}}">
                            >>> {{get_sub_field($item, 'name_file')}}
                        </a>
                        <br>
                    @endforeach --}}
                    @if(!blank(get_field($post, 'file_attachments')))
                        @forelse (get_field($post, 'file_attachments') as $item)
                            @if (!blank(get_sub_field($item, 'attachment_file')))
                                @if ((get_sub_field($item, 'name_file') != null))   
                                    <a class="register_member text-danger" href="{{ asset('storage/' .get_sub_field($item, 'attachment_file')) }}" download="{{get_sub_field($item, 'file_name')}}">
                                        >>> {{get_sub_field($item, 'name_file')}}
                                    </a>
                                @else
                                    <a class="register_member text-danger" href="{{ asset('storage/' .get_sub_field($item, 'attachment_file')) }}" download="{{get_sub_field($item, 'file_name')}}">
                                        >>> {{__('Tải file đính kèm tại đây')}}
                                    </a>
                                @endif
                            @else
                                <p>>>> {{__("File đính kèm không tồn tại")}}</p>
                            @endif
                            <br>
                        @empty
                            <p>{{__("Không có dữ liệu")}}</p>
                        @endforelse
                    @else
                        <p>{{__("Không có dữ liệu")}}</p>
                    @endif
                @elseif ($id_category[0]->name == 'Video')
                    {{-- @foreach(get_field($post, 'attachment_videos')  as $item)
                        @if (get_sub_field($item, 'api_youtube') != null)
                        <div class="video-container">
                            <iframe width="560" height="315" src="{{get_sub_field($item, 'api_youtube')}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <br>
                        @endif
                        @if (get_sub_field($item, 'api_facebook') != null)
                            <div class="fb-video" data-href="{{get_sub_field($item, 'api_facebook')}}" data-show-text="false" data-width=""><blockquote cite="{{get_sub_field($item, 'api_facebook')}}" class="fb-xfbml-parse-ignore"><a href="{{get_sub_field($item, 'api_facebook')}}"></a></blockquote></div>
                        @endif
                        <br>
                    @endforeach --}}
                    @if(!blank(get_field($post, 'attachment_videos')))
                        @forelse (get_field($post, 'attachment_videos') as $item)
                            @if (get_sub_field($item, 'api_youtube') != null)
                                <div class="video-container">
                                    <iframe width="560" height="315" src="{{get_sub_field($item, 'api_youtube')}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <br>
                            @endif
                            @if (get_sub_field($item, 'api_facebook') != null)
                                <div class="fb-video" data-href="{{get_sub_field($item, 'api_facebook')}}" data-show-text="false" data-width="">
                                    <blockquote cite="{{get_sub_field($item, 'api_facebook')}}" class="fb-xfbml-parse-ignore">
                                        <a href="{{get_sub_field($item, 'api_facebook')}}"></a>
                                    </blockquote>
                                </div>
                            @endif
                            <br>
                        @empty
                            <p>{{__("Không có dữ liệu")}}</p>
                        @endforelse
                    @else
                        <p>{{__("Không có dữ liệu")}}</p>
                    @endif
                @elseif($id_category[0]->name == 'Hình ảnh')
                    @if(!blank(get_field($post, 'attachment_images')))
                        @forelse (get_field($post, 'attachment_images') as $item)
                            <div class="imglist image-library">
                                <a href="{{ RvMedia::getImageUrl(get_sub_field($item, 'at_image'),'library_image', false, RvMedia::getImageUrl(theme_option('default_image'), 'library_image')) }}" title="{{get_sub_field($item, 'image_title')}}" data-fancybox="images" alt="{{get_sub_field($item, 'image_title')}}">
                                    <img src="{{ RvMedia::getImageUrl(get_sub_field($item, 'at_image'),'library_image', false, RvMedia::getImageUrl(theme_option('default_image'), 'library_image')) }}">
                                </a>
                                <p>{{get_sub_field($item, 'image_title')}}</p>
                            </div>  
                        @empty
                            <p>{{__("Không có dữ liệu")}}</p>
                        @endforelse
                    @else
                        <p>{{__("Không có dữ liệu")}}</p>
                    @endif
                @endif
                <div class="news-detail-social" data-href="{{$share_doc}}">
                    <div class="face-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_doc}}" target="_blank" class="face-share-link">
                            <span>
                                <i class="fab fa-facebook"></i>
                                Share
                            </span>
                        </a>
                    </div>
                </div>
                <div class="news-other">
                    <h3 class="news-other-title">{{__("Các tin khác")}}</h3>
                    <section class="row">
                        @forelse($post_doc as $events)
                            <div class="news-other-item col-md-4">
                                <a href="{{route('libraries.detail', $events->slug)}}" class="news-other-item-link shine-detail">
                                    <img src="{{ RvMedia::getImageUrl($events->thumbnail,'other', false, RvMedia::getDefaultImage()) }}" class="img-fluid w-100" alt="tin-khac" title="{{$events->name}}">
                                </a>
                                <div class="news-other-item-content">
                                    <h2 class="news-other-item-subtitle">
                                        <a class="news-other-item-subtitle-link" href="{{route('libraries.detail', $events->slug)}}" title="{{$events->name}}">{{$events->name}}</a>
                                    </h2>
                                    <div class="news-other-item-detail">
                                        {{Str::words($events->description, '15')}}
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="col-12">
                            <p>{{__("Không có dữ liệu")}}</p>
                        </div>
                        @endforelse
                    </section>
                </div>
            </section>
        </div>
        @includeif('theme.main::pages.business')
    </section>
</section>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0" nonce="p0spP2OK"></script>
<script>
	$('[data-fancybox="images"]').fancybox({
  baseClass: 'myFancyBox',
  thumbs: {
    autoStart: true,
    axis: 'x'
  }
})
</script>
@stop