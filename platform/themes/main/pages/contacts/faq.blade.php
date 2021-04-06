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
                                <a href="{{route('events.index')}}">
                                    <i class="fas fa-angle-right"></i>
                                    {{__("Hỏi đáp")}}
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
            <div class="col-lg-7 mrb20">
                <div class="row">
                    <div class="title-section w-100">
                        <h2 class="title-line text">{{$custom_field->name}}</h2>
                        @foreach(get_field($custom_field, 'faq_information') as $key => $item)
                        <article class="item-faq">
                            <div class="item-artical">
                                <i class="far fa-question-circle icon"><p>{{get_sub_field($item, 'title_ask')}}</p></i>
                            </div>
                            <div class="item-excerpt">
                                <span>{{__("Trả lời")}}:</span>
                                <div class="small-content">{{get_sub_field($item, 'best_answer')}}</div>
                                <div class="collapse small-content" id="demo{{$key}}">{{get_sub_field($item, 'all_answer')}}</div>
                                <div class="test-right">
                                    <a href="#demo{{$key}}" title="{{__("Xem hết")}}" data-toggle="collapse" class="full-content">{{__("Xem hết")}}</a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mrb20">
                {!! Form::open(['route' => 'public.send.contact', 'method' => 'POST']) !!}
                @if(session()->has('success_msg') || session()->has('error_msg') || isset($errors))
                    @if (session()->has('success_msg'))
                        <div class="alert alert-success errors-msg">
                        <p>{{__("Gửi tin nhắn thành công")}}</p>
                        </div>
                    @endif
                    @if (session()->has('error_msg'))
                        <div class="alert alert-danger errors-msg">
                        <p>{{__("Gửi tin nhắn thất bại. Vui lòng kiểm tra lại!")}}</p>
                        </div>
                    @endif
                    @if (isset($errors) && count($errors))
                        <div class="alert alert-danger errors-msg">
                            <span>{{ __($errors->first()) }}</span> <br>
                        </div>
                    @endif
                @endif
    
                <div class="row input-container">
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
                            <input class="contact-input" name="address" value="{{ old('address') }}" id="contact_address" type="text" required/>
                            <label for="contact_address">{{ trans('plugins/contact::contact.form_address') }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                    <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" name="email" value="{{ old('email') }}" id="contact_email" type="email" required/>
                            <label for="contact_email">{{ trans('plugins/contact::contact.form_email') }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                    <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" type="text" name="phone" value="{{ old('phone') }}" id="contact_phone" required/>
                            <label for="contact_phone">{{ trans('plugins/contact::contact.form_phone') }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                    <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <input class="contact-input" type="text" name="subject" value="{{ old('subject') }}" id="contact_subject" required/>
                            <label for="contact_subject">{{ trans('plugins/contact::contact.form_subject') }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                    <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="styled-input wide">
                            <textarea name="content" rows="5" id="contact_content" required>{{ old('content') }}</textarea>
                            <label for="contact_content">{{ __("Câu hỏi") }}<div class="msg text-danger">*</div></label>
                            @error('name')
                                    <span class="errors">{{__("Vui lòng nhập thông tin này!")}}</span>
                            @enderror
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
                {!! Form::close() !!}
            </div>
        </section>
    </section>
@stop