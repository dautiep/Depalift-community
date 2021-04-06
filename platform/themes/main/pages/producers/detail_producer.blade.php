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
                            <a href="{{route('producer.index')}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("NSX và cung cấp vật tư")}}
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="{{route('producer.detail', $content->slug)}}">
                                <i class="fas fa-angle-right"></i>
                                {{$content->name}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('search_producer')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('search_producer')}}">
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
                    <div class="face-share" data-href="{{$share_producer}}">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_producer}}" target="_blank" class="face-share-link">
                            <span>
                                <i class="fab fa-facebook"></i>
                                {{__("Chia sẻ")}}
                            </span>
                        </a>
                    </div>
                </div>
            </section>
        </div>
        @includeif('theme.main::pages.business')
    </section>
</section>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0" nonce="p0spP2OK"></script>
@stop