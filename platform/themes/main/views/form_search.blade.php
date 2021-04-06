
@extends('theme.main::layouts.default')
@section('content')
<div class="container">
    <div class="search-page">
        <div class="search-page_header">
            <h1 class="search-page_header__title">Tìm kiếm</h1>
        </div>
    <div class="result_search">{{__("Hiển thị")}} {{count($search_result)}} {{__("kết quả")}} {{__("trong")}} {{$time}} {{__("giây")}}</div>
        <form action="{{ route('result_search')}}">
            <div class="form-inline search__content">
                <div class="form-group search__content_form">
                <input type="text" name="q" class="form-control search__input" value="{{$key}}">
                </div>
                <div class="form-group">
                    <input type="submit" value="{{__("Tìm kiếm")}}" class="search__button">
                </div>
            </div>
        </form>
        <div class="result_content_search">
            <!-- Pagination pane -->
                {{-- <div class="text-center">
                    {{ $posts->onEachSide(1)->links('theme.main::partials.pagination') }}
                </div> --}}
            @forelse($search_result as $k => $item)
                @if($item->type == 'app_post_associates')
                    <dl class="result_content_search_list">
                        <dd class="search_item">
                            <div class="search_item_des">
                                <h3>
                                <a class="search_item_des__link" href="{{$item->url}}" target="_blank" title="{{$item->searchable->name}}">{{$item->searchable->name}}</a>
                                </h3>
                                <div class="search_item_des__content">
                                    {{$item->searchable->description}}
                                </div>
                                <hr>
                            </div>
                        </dd>
                    </dl>
                @else
                    <dl class="result_content_search_list">
                        <dd class="search_item">
                            <div class="search_item_des">
                                <h3>
                                <a class="search_item_des__link" href="{{$item->searchable->url}}" title="{{$item->searchable->name}}">{{$item->searchable->name}}</a>
                                </h3>
                                <div class="search_item_des__content">
                                    {{$item->searchable->description}}
                                </div>
                                <hr>
                            </div>
                        </dd>
                    </dl>
                @endif
            @empty
            <p  class="text-danger">{{__("Không thấy kết quả tìm kiếm !")}}</p>
            @endforelse
            
        </div>
    </div>
</div>
@stop