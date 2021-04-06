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
                            <a href="{{route('news.category', $slug->key)}}">
                                <i class="fas fa-angle-right"></i>
                                {{$category->name}}
                            </a>
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
        @includeif('theme.main::views.event_feature')
        @includeif('theme.main::pages.news')
        <div class="col-md-8">
            @forelse($child_cats as $child)
            <div class="clearfix">
            <h2 class="title-line">
                <a class="title_cat" href="{{route('news.category', $child->slug)}}">{{$child->name}}</a>
            </h2>
                <!-- List post -->
                <section class="row">
                    @php $i = 0; @endphp
                    @forelse($child['posts'] as $item)
                    <div class="col-lg-6 mrb20 content-area">
                        <div class="new-image w-100 shine-hover">
                        <a href="{{ route('news.detail_news', $item->slug) }}" title="{{$item->name}}">
                        <img src="{{ RvMedia::getImageUrl($item->image,'featured', false, RvMedia::getImageUrl(theme_option('default_image'), 'featured')) }}" alt="{{$item->name}}" class="img-fluid center-block">
                            </a>
                        </div>
                        <div class="new-content">
                            <h2>
                                <a class="new-content__name" href="{{ route('news.detail_news', $item->slug) }}" title="{{$item->name}}">{{$item->name}}</a>
                            </h2>
                            <div class="new-content-des">
                                {{$item->description}}
                            </div>
                            <a href="{{ route('news.detail_news', $item->slug) }}" class="new-content-readmore" title="{{$item->name}}">
                               {{__("Xem thêm")}}
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    @php
                    $i++;
                    if($i > 1){
                        break;
                    }
                    @endphp
                    @empty
                        <p>{{__("Không có dữ liệu")}}</p>
                    @endforelse
                </section>
            </div>
            @empty
                <p>{{__("Không có dữ liệu")}}</p>
            @endforelse
        </div>
        @includeif('theme.main::pages.business')
    </section>
</section>
@stop