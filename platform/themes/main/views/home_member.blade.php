<div class="clearfix thanhvien-huba">
    <div class="ModuleContent">
        <div class="container">
            <h3>{{__("Hội viên - Đối tác")}}</h3>
            <div class="logo-slider">
                @forelse ($member as $item)
                    <div class="item"><a href="{{$item->create_url}}" target="_blank"><img src="{{ RvMedia::getImageUrl($item->image,'image_member_slide', false, RvMedia::getDefaultImage()) }}" alt=""></a></div>
                @empty
                    <p>{{__("Không có dữ liệu")}}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>