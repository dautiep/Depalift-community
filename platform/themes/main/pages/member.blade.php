@extends('theme.main::layouts.default')
@section('content')
<div class="container">
    <section class="row">
        <section class="header-bottom mrt5 mrb10 w-100">
            <div class="form-inline">
                <div class="col-md-9 hidden-sm-down">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-sub-main">
                            <a href="#">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="{{route('associate.category_associate', $slug)}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Hội viên")}}
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="{{route('associate.category_associate', $slug)}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Thông tin hội viên")}}
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
        <div class="col-lg-8">
            <div class="col-md-12">
                @forelse ($child as $item)
                    <div class="user-wrap">
                        <h1 class="title-line">{{$item->name}}</h1>
                        <div class="row">
                            @forelse ($item['post_associates'] as $k => $associate)
                            @php
                                if($k > 3)
                                break;
                            @endphp
                                <div class="mrb30 col-xs-6 col-sm-3">
                                    <div class="user-list text-xs-center transition">
                                        <a class="center-block user-img" href="{{$associate->create_url}}" target="_blank" title="{{$associate->name}}">
                                            <img class="img-fluid center-block" src="{{ RvMedia::getImageUrl($associate->image,'image_member', false, RvMedia::getDefaultImage()) }}" alt="{{$associate->name}}">
                                        </a>
                                        <div class="user-content">
                                            <h2>
                                                <a href="{{$associate->create_url}}" target="_blank" title="{{$associate->name}}">{{$associate->name}}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <div class="col-12">
                                <p>{{__("Không có dữ liệu")}}</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>{{__("Không có dữ liệu")}}</p>
                    </div>
                @endforelse
            </div>
            <div class="col-md-12">
                <div class="user-wrap">
                    <h1 class="title-line">Danh sách hội viên</h1>
                    <div class="row">
                        @forelse ($all_member as $item)
                            <div class="mrb30 col-xs-6 col-sm-3">
                                <div class="user-list text-xs-center transition">
                                    <a class="center-block user-img" href="{{$item->create_url}}" title="{{$item->name}}" target="_blank">
                                        <img class="img-fluid center-block" src="{{ RvMedia::getImageUrl($item->image,'image_member', false, RvMedia::getDefaultImage()) }}" alt="{{$item->name}}">
                                    </a>
                                    <div class="user-content">
                                        <h2>
                                            <a href="{{$item->create_url}}" target="_blank" title="">{{$item->name}}</a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        @empty
                            
                        @endforelse
                    </div>
                </div>
                <!-- Pagination pane -->
                <div class="text-center">
                    {{ $all_member->onEachSide(1)->links('theme.main::partials.pagination') }}
                </div> 
            </div>
        </div>
        @includeif('theme.main::pages.events_highlight')
    </section>
</section>
@stop