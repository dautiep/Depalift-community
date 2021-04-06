<section class="header-menu w-100">
    <div class="col-sm-12">
        <section class="header-menu-pc" id="pc-screen">
            <div class="main-nav hidden-sm-down">
                <nav class="nav nav-inline header-menu-nav">
                    {!!
                        Menu::renderMenuLocation('main-menu', [
                            'options' => [],
                            'theme' => true,
                            'view' => 'menu',
                        ])
                    !!}
                </nav>
                {{-- <br> --}}
                <div class="all-menu">
                    <div class="ModuleContent">
                        <a role="button" class="all-menu-item __js_show_menu">
                            <div class="__menu_icon">
                                <span><i class="fas fa-bars __js_bars" aria-hidden="true"></i></span>
                                <span><i class="fas fa-times __js_times" aria-hidden="true"></i></span>
                            </div>
                            <span>{{__("Tất cả chuyên mục")}}</span>
                        </a>
                    </div>
                </div>
                <div class="ModuleContent" id="ModuleContent">
                    <nav class="nav nav-pills all-wrap __js_all_menu" id="all-menu">
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'options' => [],
                                'theme' => true,
                                'view' => 'all-menu',
                            ])
                        !!}
                    </nav>
                </div>
            </div>
        </section>
        <section class="header-menu-mb" id="mb-screen">
            <div class="all-menu">
                <div class="ModuleContent" id="ModuleContent_Mobile">
                    <a role="button" class="all-menu-item __js_show_menu">
                        <div class="__menu_icon">
                            <span><i class="fas fa-bars __js_bars" aria-hidden="true"></i></span>
                            <span><i class="fas fa-times __js_times" aria-hidden="true"></i></span>
                        </div>
                        <span>Tất cả chuyên mục</span>
                    </a>
                    <nav class="nav nav-pills all-wrap __js_all_menu" id="all-menu">
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'options' => [],
                                'theme' => true,
                                'view' => 'menu_mobile',
                            ])
                        !!}
                    </nav>
                </div>
            </div>
        </section>
    </div>
</section>