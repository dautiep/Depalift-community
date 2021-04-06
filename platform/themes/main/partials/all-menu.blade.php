@foreach($menu_nodes as $k => $menu)
    @if($k == 0)
    <li class="all-wrap__item">
        <a href="{{blank($menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$menu->url)}}" class="nav-link all-wrap__item-link transition active">{{ $menu->title ?? '' }}</a>
    </li>
    @else
    <li class="all-wrap__item">
        <a href="{{blank($menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$menu->url)}}" class="nav-link all-wrap__item-link transition">{{ $menu->title ?? '' }}</a>
        @if(!blank($menu->child) && $menu->child->count() > 0)
        <nav class="sub-menu">
            @foreach($menu->child as $sub_menu)
            <a href="{{blank($sub_menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$sub_menu->url)}}" class="nav-link transition {{$sub_menu->css_class}}">{{ $sub_menu->title ?? '' }}</a>
            @endforeach
        </nav>
        @endif
    </li>
    @endif
@endforeach