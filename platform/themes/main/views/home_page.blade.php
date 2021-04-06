<section class="container">
    <section class="row">
        @includeif('theme.main::views.event_feature')
        @includeif('theme.main::pages.news')
        <div class="col-md-8">
            <div class="clearfix">
            <h2 class="title-line">{{get_field($custom_field, 'hoat_dong_cua_hiep_hoi')}}</h2>
                <section class="row">
                    <div class="col-lg-6">
                        @foreach(get_field($custom_field, 'newshome') as $k => $item)
                            @php
                                if($k == 1)
                                    break;
                            @endphp
                            <article class="active-home">
                                <figure class="mask">
                                    <a href="{{ route('events.detail', get_sub_field($item, 'url_news')) }}" class="shine-hover w-100" target="_self" title="{{get_sub_field($item, 'title_news')}}">
                                        <img class="img-fluid center-block w-100" src="{{ RvMedia::getImageUrl(get_sub_field($item, 'image_news'),'image_events_home', false, RvMedia::getDefaultImage()) }}" alt="{{get_sub_field($item, 'title_news')}}">
                                    </a>
                                </figure>
                                <div class="contennt-home">
                                    <h3>
                                    <a href="{{ route('events.detail', get_sub_field($item, 'url_news')) }}" class="first-link" target="_self" title="{{get_sub_field($item, 'title_news')}}">
                                        {{get_sub_field($item, 'title_news')}}
                                    </h3>
                                <p>{{Str::words(get_sub_field($item, 'description_news'), 20)}}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @php
                        $i = 0;
                    @endphp
                    <div class="col-lg-6 mrb20">
                        @forelse (get_field($custom_field, 'newshome') as $item)
                        @if($i != 0)
                            <div class="media boder">
                                <figure class="mask">
                                    <a href="{{route('events.detail', get_sub_field($item, 'url_news'))}}" class="media-left shine-hover" target="_self" title="{{get_sub_field($item, 'title_news')}}">
                                        <img src="{{RvMedia::getImageUrl(get_sub_field($item, 'image_news'), 'images_events_home_child', false, RvMedia::getDefaultImage())}}" alt="{{get_sub_field($item, 'title_news')}}" class="hvr-glow media-object">
                                    </a>
                                </figure>
                                <div class="media-body">
                                    <h4>
                                        <a class="pages-text first-link" target="_self" title="{{get_sub_field($item, 'title_news')}}" href="{{route('events.detail', get_sub_field($item, 'url_news'))}}">{{Str::words(get_sub_field($item, 'description_news'), '10')}}</a>
                                    </h4>
                                <time class="clearfix mrt10">{{get_sub_field($item, 'date_news')}}</time>
                                </div>
                            </div>
                        @endif
                        @php $i++; @endphp
                        @empty
                            <p>{{__('Không có dữ liệu')}}</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
        <div class="col-md-4">
            @includeif('theme.main::pages.activity')
        </div>
    </section>
</section>