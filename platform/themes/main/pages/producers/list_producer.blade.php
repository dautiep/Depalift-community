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
        <div class="col-lg-8">
            <div class="user-wrap">
                <h1 class="title-line">{{__("NSX và cung cấp vật tư")}}</h1>
                <div class="row">
                    @forelse ($all_post as $item)
                    <div class="mrb30 col-xs-6 col-sm-3">
                        <div class="user-list text-xs-center transition">
                            <a class="center-block user-img" href="{{route('producer.detail', $item->slug)}}" title="{{$item->name}}">
                                <img class="img-fluid center-block" src="{{ RvMedia::getImageUrl($item->image,'image_member', false, RvMedia::getImageUrl(theme_option('default_image'), 'image_member')) }}" alt="{{$item->name}}">
                            </a>
                            <div class="user-content">
                                <h2>
                                    <a href="{{route('producer.detail', $item->slug)}}" title="{{$item->name}}">{{Str::words($item->name, '7')}}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="mrb30 col-xs-6 col-sm-3">
                        <p>{{__("Không có dữ liệu")}}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @includeif('theme.main::pages.business')
    </section>
</section>
@stop