@foreach($menu_nodes as $key => $menu)
    @if($key == 0)
    <li class="nav-home nav-item">
        <a href="{{blank($menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$menu->url)}}"><i class="fas fa-home"></i></a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-item-link transition" href="{{blank($menu->url) ? 'javascript:void(0);' : Language::getLocalizedURL(app()->getLocale(),$menu->url)}}">{{ $menu->title ?? '' }}
            <i class="fas fa-angle-down" aria-hidden="true"></i>
        </a>
        @if(!blank($menu->child) && $menu->child->count() > 0)
        <div class="mainmenu-sub">
            @foreach($menu->child as $sub_menu)
                <a class="transition {{$sub_menu->css_class}}" href="{{ blank($sub_menu->url) ? 'javascript:;' : Language::getLocalizedURL(app()->getLocale(),$sub_menu->url) }}" target="_self">
                    <i class="fas fa-angle-right" aria-hidden="true"></i>
                    {{ $sub_menu->title ?? '' }}
                </a>
            @endforeach
        </div>
        @endif
    </li>
    @endif
@endforeach