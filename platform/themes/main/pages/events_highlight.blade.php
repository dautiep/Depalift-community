<h2 class="title-line">{{__("Sự kiện nổi bật")}}</h2>
<div class="row">
    <div class="qc-content">
        <div class="force-overflow">
            @forelse($events_highlight as $item)
            <figure class="mask">
                <a class="center-block mrb15 text-xs-center transition shine-hover w-100" target="_self" href="{{ route('events.detail', $item->slug) }}" title="{{$item->name}}">
                    <img class="img-fluid w-100" src="{{ RvMedia::getImageUrl($item->image,'event_feature', false, RvMedia::getImageUrl(theme_option('default_image'), 'event_feature')) }}" alt="{{$item->name}}">
                </a>
            </figure>
            @empty
            <p>{{__("Không có dữ liệu")}}</p>
            @endforelse    
        </div>
    </div>
</div>
