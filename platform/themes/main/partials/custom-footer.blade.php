@foreach($menu_nodes as $key => $menu)
<div class="col-md-12 col-sm-6 mrb20 footer-item">
    <h5>
        <a class="transition" href="{{blank($menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$menu->url)}}" target="_self">{{ $menu->title ?? '' }}</a>
    </h5>
    @if(!blank($menu->child) && $menu->child->count() > 0)
        @foreach($menu->child as $sub_menu)
        <a href="{{blank($sub_menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$sub_menu->url)}}" class="nav-link transition clearfix" target="_self">
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <span>{{$sub_menu->title ?? ''}}</span>
        </a>
        @endforeach
    @endif
</div>
@endforeach
