<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {!! SeoHelper::render() !!}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <link rel="icon" href="{{Theme::asset()->url('images/logo_bk.png')}}" />
        {!! Theme::partial('head') !!}
    </head>
        <body @if (class_exists('Language', false) && Language::getCurrentLocaleRTL()) dir="rtl" @endif>
        <script>
            var district_thuong_tru = "{{route('show-district-thuong-tru')}}";
            var district_tam_tru = "{{route('show-district-tam-tru')}}";
        </script>

        {!! Theme::partial('header') !!}
        
        @yield('content')

        {!! Theme::partial('footer') !!}
        <span id="icon">
            <i class="fa fa-angle-double-up" aria-hidden="true"></i>
        </span>
        {!! Theme::partial('scripts') !!}
    </body>

</html>