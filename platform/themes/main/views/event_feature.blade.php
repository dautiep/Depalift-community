<div class="col-lg-8 mrb20">
    <div class="clearfix">
        <article class="new-first mrb5">
            <section class="row">
                <div class="col-md-4">
                    <div class="content-first">
                        <h1>
                            <a class="first-link" href="{{route('news.detail_news',$new_post[0]->slug)}}" title="{{$new_post[0]->name}}">
                                {{$new_post[0]->name}}
                            </a>
                        </h1>
                    </div>
                </div>
                <div class="col-md-8">
                    <figure class="mask">
                        <a class="center-block shine-hover w-100" target="_self" href="{{route('news.detail_news',$new_post[0]->slug)}}" title="{{$new_post[0]->name}}">
                            <img class="img-fluid center-block w-100" src="{{ RvMedia::getImageUrl($new_post[0]->image,'news_focus', false, RvMedia::getDefaultImage()) }}" alt="">
                        </a>
                    </figure>
                </div>
            </section>
        </article>
        @php $i = 0; @endphp
        @forelse ($new_post as $item)
            @if($i != 0)
                <div class="new-left mrb5 relative">
                    <div class="new-home-img">
                        <figure class="mask w-100">
                            <a href="{{route('news.detail_news',$item->slug)}}" class="center-block shine-hover w-100" target="_self" title="{{$item->name}}">
                                <img class="img-fluid w-100" src="{{RvMedia::getImageUrl($item->image,'image_new', false, RvMedia::getDefaultImage())}}" alt="">
                            </a>
                        </figure>
                    </div>
                    <div class="content-new-left">
                        <h3>
                            <a href="{{route('news.detail_news',$item->slug)}}" title="{{$item->name}}" class="first-link">{{$item->name}}</a>
                        </h3>
                    </div>
                </div>
            @endif
            @php $i++; @endphp 
        @empty
            <p>{__("Không có dữ liệu")}</p>
        @endforelse
    </div>
</div>