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
                            <a href="{{route('events.index')}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Sự kiện")}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('search')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('search')}}">
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
        {{-- New-post --}}
        <div class="col-lg-8 mrb20">
            @if (count($news_events))
                <div class="clearfix">
                    <article class="new-first mrb5">
                        <section class="row">
                            <div class="col-md-4">
                                <div class="content-first">
                                    <h1>
                                        <a class="first-link" href="{{route('events.detail',$news_events[0]->slug)}}" title="{{$news_events[0]->name}}">
                                            {{$news_events[0]->name}}
                                        </a>
                                    </h1>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <figure class="mask">
                                    <a class="center-block shine-hover w-100" target="_self" href="{{route('events.detail',$news_events[0]->slug)}}" title="{{$news_events[0]->name}}">
                                        <img class="img-fluid center-block w-100" src="{{ RvMedia::getImageUrl($news_events[0]->image,'news_focus', false, RvMedia::getImageUrl(theme_option('default_image'), 'news_focus')) }}" alt="{{$news_events[0]->name}}">
                                    </a>
                                </figure>
                            </div>
                        </section>
                    </article>
                    @php $i = 0; @endphp
                    @forelse ($news_events as $item)
                        @if($i != 0)
                            <div class="new-left mrb5 relative">
                                <div class="new-home-img">
                                    <figure class="mask w-100">
                                        <a href="{{route('events.detail',$item->slug)}}" class="center-block shine-hover w-100" target="_self" title="{{$item->name}}">
                                            <img class="img-fluid w-100" src="{{RvMedia::getImageUrl($item->image,'image_new', false, RvMedia::getImageUrl(theme_option('default_image'), 'image_new'))}}" alt="{{$item->name}}">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-new-left">
                                    <h3>
                                        <a href="{{route('events.detail',$item->slug)}}" title="{{$item->name}}" class="first-link">{{Str::words($item->name, '8')}}</a>
                                    </h3>
                                </div>
                            </div>
                        @endif
                        @php $i++; @endphp 
                    @empty
                        <p>{__("Không có dữ liệu")}</p>
                    @endforelse
                </div>
            @else
                <p>{{__("Không có dữ liệu")}}</p>
            @endif 
            <div class="clearfix events-mrt">
                <h2 class="title-line">{{__("Văn bản mới")}}</h2>
                <!-- List post -->
                <section class="row">
                    @forelse($all_posts_events as $events)
                    <div class="col-lg-6 mrb20 content-area">
                        <div class="new-image w-100 shine-hover">
                            <a href="{{ route('events.detail', $events->slug)}} ">
                                <img src="{{ RvMedia::getImageUrl($events->image,'featured', false, RvMedia::getImageUrl(theme_option('default_image'), 'featured')) }}" alt="" class="img-fluid center-block">
                            </a>
                        </div>
                        <div class="new-content">
                            <h2>
                                <a class="new-content__name" href="{{ route('events.detail', $events->slug)}}" title="{{$events->name}}">{{$events->name}}</a>
                            </h2>
                            <div class="new-content-des">
                                {{Str::words($events->description, '25')}}
                            </div>
                            <a href="{{ route('events.detail', $events->slug) }}" class="new-content-readmore" title="{{$events->name}}">
                            {{__("Xem thêm")}}
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <p>{{__("Không có dữ liệu")}}</p>
                    @endforelse
                </section>
                <!-- Pagination pane -->
                <div class="text-center">
                    {{ $all_posts_events->onEachSide(1)->links('theme.main::partials.pagination') }}
                </div>
            </div>
        </div>
        {{-- End news-post --}}
        {{-- Featured_events --}}
        <div class="col-lg-4 mrb20">
            <h4 class="title-line">{{__("Tin mới")}}</h4>
            @if (count($featured_events))
                <div class="clearfix">
                    @forelse($featured_events as $events)
                    <div class="news-right mrb10">
                        <h4>
                            <a class="news-title news-hover" target="_self" href="{{ route('events.detail', $events->slug) }}" title="{{$events->name}}">{{$events->name}}</a>
                        </h4>
                        <time class="clearfix">{{date_format($events->created_at, 'd/m/yy')}}</time>
                    </div>
                    @empty
                    <div class="news-right mrb10">
                        <p>{{ __("Chưa có tin tức mới")}}</p>
                    </div>
                    @endforelse
                </div>
            @else
                <p>{{__("Không có dữ liệu")}}</p>
            @endif


            @includeif('theme.main::pages.activity')


        </div>
        {{-- End featured_events --}}
    </section>
</section>
@stop