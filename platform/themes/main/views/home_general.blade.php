<div class="general-total">
    <section class="container">
        <section class="row">
            @forelse($cats as $k => $category)
                @php
                    if($k > 6)
                    break;
                @endphp 
                <article class="col-lg-3 col-sm-6 mrb40">
                    <h3 class="general-line">{{$category->name}}</h3>
                    <article class="list-first w-100">
                        @foreach($category['posts'] as $post)
                        <figure class="mask">
                            <a class="hvr-glow center-block transition relative img-home shine-hover w-100" href="{{ route('news.detail_news', [$post->slug]) }}">
                                <img class="img-fluid w-100" src="{{ RvMedia::getImageUrl($post->image,'image_component', false, RvMedia::getImageUrl(theme_option('default_image'), 'image_compoent')) }}" alt="{{@$category['posts'][0]->name}}">  
                                <div class="home-content-list general-summary">{{Str::words($post->name, '12')}}</div>
                            </a>
                        </figure>
                            @break;
                        @endforeach
                    </article>
                    
                    @forelse($category['posts'] as $key => $post)
                        @php
                            if($key == 0)
                                continue;
                        @endphp
                        @php
                            if($key == 3)
                                break;
                        @endphp
                        <div class="general-media">
                            <div class="general-left">
                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </div>
                            <div class="general-right">
                                <h4 class="title-h4">
                                <a class="general-title general-summary" href="{{ route('news.detail_news', $post->slug) }}">
                                        {{Str::words($post->name, 13)}} 
                                    </a>
                                </h4>
                            </div> 
                        </div>
                    @empty
                        <p>{{__("Không có dữ liệu")}}</p>
                    @endforelse
                </article>
            @empty
                <p>{{__("Không có dữ liệu")}}</p>
            @endforelse

            @forelse($events as $k => $category)
            
                @php
                    if($k > 0)
                    break;
                @endphp 
                <article class="col-lg-3 col-sm-6 mrb40">
                    <h3 class="general-line">{{$category->name}}</h3>
                    @forelse($category->child_cats as $k => $cat)
                        @php
                            if($k == 0)
                                continue;
                        @endphp     
                        <article class="list-first w-100">
                            @foreach($cat['posts_events_desc'] as $post)
                            <figure class="mask">
                                <a class="hvr-glow center-block transition relative img-home shine-hover w-100" href="{{ route('events.detail', [$post->slug]) }}">
                                    <img class="img-fluid w-100" src="{{ RvMedia::getImageUrl($post->image,'image_component', false, RvMedia::getImageUrl(theme_option('default_image'), 'image_compoent')) }}" alt="{{@$category['posts'][0]->name}}">  
                                    <div class="home-content-list general-summary">{{Str::words($post->name, '12')}}</div>
                                </a>
                            </figure>
                                @break;
                            @endforeach
                        </article>
                        @forelse($cat['posts_events_desc'] as $key => $post)
    
                            @php
                                if($key == 0)
                                    continue;
                            @endphp
                            @php
                                if($key == 3)
                                    break;
                            @endphp
                            <div class="general-media">
                                <div class="general-left">
                                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                                </div>
                                <div class="general-right">
                                    <h4 class="title-h4">
                                    <a class="general-title general-summary" href="{{ route('events.detail', $post->slug) }}">
                                            {{Str::words($post->name, 13)}} 
                                        </a>
                                    </h4>
                                </div> 
                            </div>
                        @empty
                            <p>{{__("Không có dữ liệu")}}</p>
                        @endforelse
                    @break;
                    @empty
                    <p>{{__("Không có dữ liệu")}}</p>
                    @endforelse
                    
                </article>
            @empty
                <p>{{__("Không có dữ liệu")}}</p>
            @endforelse
        </section>
    </section>
</div>


