<div class="col-lg-4 mrb20">
    <h4 class="title-line">{{__("Tin mới")}}</h4>
    <div class="clearfix">
        @forelse($lasted_posts as $post)
        <div class="news-right mrb10">
            <h4>
                <a class="news-title news-hover" target="_self" href="{{ route('news.detail_news', $post->slug) }}" title="{{$post->name}}">{{$post->name}}</a>
            </h4>
            <time class="clearfix">{{date_format($post->created_at, 'd/m/yy')}}</time>
        </div>
        @empty
        <div class="news-right mrb10">
            <p>{{ __("Chưa có tin tức mới")}}</p>
        </div>
        @endforelse
    </div>
</div>