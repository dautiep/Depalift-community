@extends('theme.main::layouts.default')
@section('content')
<div class="container">
    <section class="row">
        <section class="header-bottom mrt5 mrb10 w-100">
            <div class="form-inline">
                <div class="col-md-9 hidden-sm-down">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-sub-main">
                            <a href="{{route('public.index')}}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-sub">
                            <a href="{{ route("contact.index")}}">
                                <i class="fas fa-angle-right"></i>
                                {{__("Liên hệ")}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 form-search">
                    <form action="{{ route('result_search')}}">
                        <div class="form-search--input" id="form-search">
                            <input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
                            <button type="submit">
                                <a href="{{ route('result_search')}}">
                                    <i class="fas fa-search icon__search"></i>
                                </a>
                            </button>
                        </div>
                        <span class="btn-search __js_show_search" id="menu-search">{{__("Tìm kiếm")}}
                            <i class="fas fa-search button-search"></i>
                        </span>
                    </form>
                </div>
            </div>
        </section>
    </section>
</div>
<section class="container">
    <section class="row">
        <div class="col-lg-12 mrb20">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4593.625980815248!2d105.8072461305224!3d21.068251906516586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aae60c65037b%3A0x4cc5cb9722ff2f73!2zMTggTmfDtSA2NDcgTOG6oWMgTG9uZyBRdcOibiwgWHXDom4gTGEsIFTDonkgSOG7kywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1605527142617!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="col-md-6 mrb20">
            <div class="contact-info">
                <h1>{{__("Liên hệ")}}</h1>
                <div class="address">
                    @foreach (get_field($custom_field, 'contact_information') as $key => $item)
                        @php
                            if($key == 1)
                                break;
                        @endphp
                        <h3 class="title-h3">{{get_sub_field($item, 'info_contact')}}</h3>
                    @endforeach
                    <table class="content-contact">
                        <tbody>
                            @foreach(get_field($custom_field, 'contact_information') as $key => $item)
                                @php
                                    if($key == 0)
                                        continue;
                                @endphp
                                <tr>
                                    <td><i class="{{get_sub_field($item, 'info_icon')}}"></i></td>
                                    <td colspan="3">{{get_sub_field($item, 'info_contact')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="address">
                    @foreach (get_field($custom_field, 'suport_information') as $key=> $item)
                        <h3 class="title-h3">{{get_sub_field($item, 'name_support')}}</h3>
                        <p class="title-p"> @php echo get_sub_field($item, 'content_support') @endphp</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 mrb20">
            <form action="{{route('submit_contacts')}}" method="POST" enctype="multipart/form-data">
            @csrf
                @if(session()->has('success_msg') || session()->has('error_msg') || isset($errors))
                    @if (session('msg'))
                        <div class="col-12 alert alert-{{session('type')}} errors-msg">{{session('msg')}}</div>
                    @endif
                    @if (isset($errors) && count($errors) )
                        <div class="alert alert-danger errors-msg">
                            <span>{{ __($errors->first()) }}</span> <br>
                        </div>
                    @endif
                @endif

                <div class="row input-container">
                    <div class="col-sm-12">
                        <h2 class="problem">{{__("Tiếp nhận thông tin online")}}</h2>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="name" type="text" value="{{ old('name') }}" id="contact_name" required/>
                            <label for="contact_name">{{ trans('plugins/contact::contact.form_name') }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="company" type="text" value="{{ old('company') }}" id="contact_name" required/>
                            <label for="contact_company">{{ __("Doanh nghiệp/Đơn vị") }}<div class="msg text-danger">*</div></label>
                            @error('company')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="number_company" type="text" value="{{ old('number_company') }}" id="contact_number_company" required/>
                            <label for="contact_number_company">{{ __("Mã số doanh nghiệp") }}<div class="msg text-danger">*</div></label>
                            @error('number_company')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="address" value="{{ old('address') }}" id="contact_address" type="text" required/>
                            <label for="contact_address">{{ trans('plugins/contact::contact.form_address') }}<div class="msg text-danger">*</div></label>
                            @error('address')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="email" value="{{ old('email') }}" id="contact_email" type="email" required/>
                            <label for="contact_email">{{ trans('plugins/contact::contact.form_email') }}<div class="msg text-danger">*</div></label>
                            @error('email')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" type="text" name="phone" value="{{ old('phone') }}" id="contact_phone" required/>
                            <label for="contact_phone">{{ trans('plugins/contact::contact.form_phone') }}<div class="msg text-danger">*</div></label>
                            @error('phone')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="custom02">
                            <h2 class="problem">{{__("Vấn đề cần trợ giúp")}}<div class="msg text-danger">*</div></h2>
                            <div class="row">
                                @foreach (get_field($custom_field, 'problem_support') as $key=> $item)         
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="contact_problem"><input class="radio-input" type="radio" name="problem" value="{{get_sub_field($item, 'name_problem')}}">{{get_sub_field($item, 'name_problem')}}</label>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-sm-6">
                                    @error('problem')
                                        <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <textarea name="content" rows="5" id="contact_content" required>{{ old('content') }}</textarea>
                            <label for="contact_content">{{ trans('plugins/contact::contact.form_message') }}<div class="msg text-danger">*</div></label>
                            @error('content')
                                <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input custom-file-inputt" type="file" name="file" value="{{ old('file') }}" id="contact_file" />
                            <label for="contact_file">{{__("Vui lòng chọn file upload (word, excel, pdf)")}}</label>
                        </div>
                    </div>
                    @if (setting('enable_captcha') && is_plugin_active('captcha'))
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_robot" class="control-label required">{{ trans('plugins/contact::contact.confirm_not_robot') }}</label>
                                {!! Captcha::display('captcha') !!}
                                {!! Captcha::script() !!}
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-12"><p>{!! trans('plugins/contact::contact.required_field') !!}</p></div>
                <div class="col-sm-3">
                    <input value="{{__("Gửi")}}" class="btn-lrg submit-btn" type="submit">
                </div>
            </form>
        </div>
    </section>
</section>
@stop