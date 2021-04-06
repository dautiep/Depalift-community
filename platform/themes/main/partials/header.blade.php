<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-transfer">
                    <a class="text-transfer__link" href="{{Language::getLocalizedURL('vi')}}">TIẾNG VIỆT |</a>
                    <a class="text-transfer__link" href="{{Language::getLocalizedURL('en')}}">ENGLISH</a>
                </div>
                <div class="menu-row">
                    <a class="d-block logo" href="{{ route('public.index') }}">
                        <img class="img-fluid w-100" src="{{RvMedia::getImageUrl(theme_option('header_logo'),'logo', false, RvMedia::getImageUrl(theme_option('default_image'))) }}" alt="depalift-community">
                    </a>
                    <span class="qc-top-image">
                        <img class="img-fluid w-100" src="{{RvMedia::getImageUrl(theme_option('header_banner'),'banner', false, RvMedia::getImageUrl(theme_option('default_image'))) }}" alt="depalift-community">
                    </span>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header-nav header-sticky" id="sticky-menu">
    <div class="container">
        <div class="row">
            @includeif('theme.main::views.nav')
        </div>
    </div>
</div>
    