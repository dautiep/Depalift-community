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
                            <a href="{{route('news.index')}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Điểm tin")}}
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            @if (count($category))          
                                <a href="{{route('news.category', $category[0]->slug)}}">
                                    <i class="fas fa-angle-right"></i>
                                    {{$category[0]->name}}
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('search_news')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('search_news')}}">
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
                <h1 class="news-detail-title">{{$content->name}}</h1>
                <time class="news-detail-time">
                    <i class="fas fa-calendar"></i>
                    {{date_format($content->created_at, 'd/m/yy')}}
                </time>
                <div class="news-detail-content">
                    @php echo $content->content @endphp
                </div>
                <br>
                <div class="news-detail-social">
                    <div class="face-share" data-href="{{$share_new}}">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_new}}" target="_blank" class="face-share-link">
                            <span>
                                <i class="fab fa-facebook"></i>
                                {{__("Chia sẻ")}}
                            </span>
                        </a>
                    </div>
                </div>
                <div class="news-other">
                    <h3 class="news-other-title">{{__("Các tin khác")}}</h3>
                    <section class="row">
                        @forelse($posts_by_cat as $post)
                        <div class="news-other-item col-md-4">
                        <a href="{{ route('news.detail_news', $post->slug) }}" class="news-other-item-link" title="{{$post->name}}">
                            <img src="{{ RvMedia::getImageUrl($post->image,'other', false, RvMedia::getDefaultImage()) }}" class="img-fluid w-100" alt="{{$post->name}}">
                            </a>
                            <div class="news-other-item-content">
                                <h2 class="news-other-item-subtitle">
                                <a class="news-other-item-subtitle-link" href="{{ route('news.detail_news', $post->slug) }}" title="{{$post->name}}">{{$post->name}}</a>
                                </h2>
                                <div class="news-other-item-detail">
                                    <div>
                                        {{$post->description}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
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
@stop