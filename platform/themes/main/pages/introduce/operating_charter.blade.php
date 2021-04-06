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
                            <a href="{{ route('introduction.index_introduce')}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Giới thiệu")}}
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                        <a href="{{ route('introduction.operatingCharter')}}">
                                <i class="fas fa-angle-right"></i>
                                {{@$page->name}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('result_search')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('result_search')}}">
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
            <h1 class="news-detail-title">{{@$page->name}}</h1>
                @if ($page->created_at)
                    <time class="news-detail-time">
                        <i class="fas fa-calendar"></i>
                        {{date_format(@$page->created_at, 'd/m/yy')}}
                    </time>
                @endif
                <div class="news-detail-content">
                    {!! @$page->content !!}
                </div>
                <br>
                <div class="news-detail-social" data-href="{{$share_charter}}">
                    <div class="face-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_charter}}" target="_blank" class="face-share-link">
                            <span>
                                <i class="fab fa-facebook"></i>
                                {{__("Chia sẻ")}}
                            </span>
                            
                        </a>
                    </div>
                </div>
            </section>
        </div>
        @includeIf('theme.main::pages.business')
    </section>
</section>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0" nonce="p0spP2OK"></script>
@stop