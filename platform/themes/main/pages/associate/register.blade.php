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
                        <a href="{{ route('register_member')}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Đăng ký hội viên")}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('search_member')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('search_member')}}">
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
                @if (@$page->created_at)
                    <time class="news-detail-time">
                        <i class="fas fa-calendar"></i>
                        {{date_format(@$page->created_at, 'd/m/yy')}}
                    </time>
                @endif

                <div class="news-detail-content">
                   {!! @$page->content !!}
                </div>
                @foreach(get_field($custom_field, 'register')  as $item)
                    <a class="register_member" href="{{ asset('storage/' .get_sub_field($item, 'register_form')) }}" download="{{get_sub_field($item, 'name_form')}}">
                        >>> {{get_sub_field($item, 'name_form')}}
                    </a>
                    <br>
                @endforeach
                <br>
                <div class="news-detail-social" data-href="{{$share_register}}">
                    <div class="face-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$share_register}}" target="_blank" class="face-share-link">
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