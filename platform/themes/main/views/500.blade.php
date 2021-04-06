@extends(Theme::getThemeNamespace() . '::views.error-master')

@section('code', '500')
@section('title', __('Page could not be loaded'))

@section('message')
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-12 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">500</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">{!! __("Xảy ra lỗi hệ thống") !!}</h3>
                            <a href="{{ route('public.index') }}" class="link_404">{!! __("Quay về trang chủ") !!}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
