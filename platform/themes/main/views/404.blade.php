@extends(Theme::getThemeNamespace() . '::views.error-master')


@section('title', __('Page could not be found'))
@section('message')
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-12 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">404</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">{!! __("Hình như bạn bị lạc") !!}</h3>
                            <p>{!! __("Trang bạn đang tìm kiếm không có sẵn!") !!}</p>
                            <a href="{{ url()->previous() }}" class="link_404">{!! __("Trở lại trang trước") !!}</a>
                            <a href="{{ route('public.index') }}" class="link_404">{!! __("Quay về trang chủ") !!}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

