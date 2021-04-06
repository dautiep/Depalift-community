<div class="col-md-4 col-right cmszone">
    <h2 class="title-line">{{__("Giới thiệu doanh nghiệp")}}</h2>
    <div class="qc-content">
        <div class="scrollbar">
            <div class="force-overflow">
                @forelse ($member as $item)
                    <figure class="mask">
                        <a class="center-block mrb15 text-xs-center transition shine-hover" target="_blank" href="{{$item->create_url}}" title="{{$item->name}}">
                            <img class="img-fluid" src="{{ RvMedia::getImageUrl($item->image,'image_member_home', false, RvMedia::getDefaultImage()) }}" alt="{{$item->name}}">
                        </a>
                    </figure>
                @empty
                    <p class="no-data">{{__("Không có dữ liệu")}}</p>
                @endforelse
            </div>
        </div>
    </div>
    <h2 class="title-line">{{__("Sự kiện nổi bật")}}</h2>
    <div class="qc-content">
        <div class="force-overflow">
            @forelse($lasted_events as $item)
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