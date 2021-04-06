@extends('theme.main::layouts.default')
@section('content')
<div class="container">
    <section class="row">
        <section class="header-bottom mrt5 mrb10 w-100">
            <div class="form-inline">
                <div class="col-md-9 hidden-sm-down">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-sub-main">
                            <a href="#">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="#">
                                <i class="fas fa-angle-right"></i>
                                Sự kiện
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="#">
                                <i class="fas fa-angle-right"></i>
                                Liên kết Website
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <div class="form-search--input" id="form-search">
                        <input class="input-search" type="text" autocomplete="false" placeholder="Tìm kiếm">
                        <button><i class="fas fa-search"></i></button>
                    </div>

                    <span class="btn-search __js_show_search" id="menu-search">Tìm kiếm
                        <i class="fas fa-search button-search"></i>
                    </span>
                </div>
            </div>
        </section>
    </section>
</div>
@stop