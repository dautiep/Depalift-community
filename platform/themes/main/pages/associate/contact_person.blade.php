@extends('theme.main::layouts.default')
@section('content')
    <section>
        <div class="container">
            @php
                $tabActive = request('tab', 'pills-home') ;
            @endphp
            <ul class="nav nav-pills mb-3 pt-5" id="pills-tab" role="tablist">
                <li class="nav-item w-50 text-center">
                    <a class="nav-link nav-link-tab {{ $tabActive == 'pills-home' ? 'active' : '' }}" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">HỘI VIÊN CÁ NHÂN</a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a class="nav-link nav-link-tab {{ $tabActive == 'pills-profile' ? 'active' : '' }}" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">HỘI VIÊN TỔ CHỨC</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade  {{ $tabActive == 'pills-home' ? 'show active' : '' }}" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <form action="{{route('submit-form-personal')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @if(session()->has('success_msg') || session()->has('error_msg') || isset($errors))
                                @if (session('msg'))
                                    <div class="col-md-12 pt-4">
                                        <div class="alert alert-{{session('type')}}" role="alert">{{session('msg')}}</div>
                                    </div>
                                @endif
                            @endif
                            {{-- Thông tin cá nhân --}}

                            <div class="col-md-12">
                                <h2 class="problem">1.{{ __('Thông tin cá nhân') }}</h2>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="name" type="text"
                                                   value="{{ old('name') }}"
                                                   id="contact_name"/>
                                            <label for="contact_name">{{ trans('plugins/contact::contact.form_name') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('name')
                                            <span class="errors">
                                            <strong>
                                                {{$errors->first('name')}}
                                            </strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_sex" class="__focus">{{ __('Giới tính') }}</label>
                                            <select class="contact-input" name="sex" type="text" value="{{ old('sex') }}"
                                                    id="contact_sex">
                                                <option value="0" {{(old('sex') == 0)  ? 'selected' : ''}}>Nam</option>
                                                <option value="1" {{(old('sex') == 1)  ? 'selected' : ''}}>Nữ</option>
                                                <option value="2" {{(old('sex') == 2)  ? 'selected' : ''}}>Giới tính khác</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="birth_day" type="date"
                                                   value="{{ old('birth_day') }}" id="contact_birth_day"/>
                                            <label for="contact_birth_day" class="__focus">{{ __('Ngày sinh') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('birth_day')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('birth_day')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_place" class="__focus">{{ __('Chọn nơi sinh') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="place_birth" type="text"
                                                    value="{{ old('place_birth') }}" id="contact_place" style="height: auto;">
                                                <option value="">Chọn tỉnh/Thành phố</option>
                                                @if(!blank($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('place_birth') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('place_birth')
                                                <span class="errors">
                                                    <strong>{{$errors->first('place_birth')}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="country" type="text" value="{{ old('country') }}"
                                                   id="contact_country"/>
                                            <label for="contact_country">{{ __('Quốc tịch') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('country')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('country')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="religion" type="text"
                                                   value="{{ old('religion') }}" id="contact_religion"/>
                                            <label for="contact_religion">{{ __('Tôn giáo') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('religion')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('religion')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="identify"
                                                   value="{{ old('identify') }}"
                                                   id="contact_id_card" type="text"/>
                                            <label for="contact_id_card">{{ __('CMND') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('identify')
                                            <span class="errors">
                                        <strong>{{$errors->first('identify')}}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="date_range"
                                                   value="{{ old('date_range') }}"
                                                   id="contact_date_range" type="date"/>
                                            <label for="contact_date_range" class="__focus">{{ __('Ngày cấp') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('date_range')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('date_range')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <label class="__focus" for="contact_issued_by">{{ __('Nơi cấp') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="issued_by" type="text" id="contact_issued_by">
                                                @if(!blank($provinces))
                                                    <option value="" selected="selected">Chọn Tỉnh/TP</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('issued_by') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('issued_by')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('issued_by')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_permanent"
                                                   class="__focus">{{ __('Địa chỉ thường trú(Nhập theo hộ khẩu)') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="pernament_main" type="text" id="contact_permanent">
                                                <option value="">Chọn Tỉnh/TP</option>
                                                @if(!blank($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('pernament_main') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('pernament_main')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('pernament_main')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_district" class="__focus">{{ __('Quận/Huyện') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="district_main" type="text"
                                                    value="{{ old('district_main') }}" id="contact_district">
                                                <option value="" selected="selected">Chọn Quận/Huyện</option>
                                            </select>
                                            @error('district_main')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('district_main')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="address_main" value="{{ old('address_main') }}"
                                                   id="contact_diachi" type="text"/>
                                            <label for="contact_diachi">{{ __('Vui lòng nhập địa chỉ') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('address_main')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('address_main')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_permanent1"
                                                   class="__focus">{{ __('Địa chỉ liên hệ(Nhập theo sổ tạm trú)') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="pernament_sub" type="text"
                                                    value="{{ old('pernament_sub') }}" id="contact_permanent1">
                                                <option value="" selected="selected">Chọn Tỉnh/TP</option>
                                                @if(!blank($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('pernament_sub') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('pernament_sub')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('pernament_sub')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_district1" class="__focus">{{ __('Quận/Huyện') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="district_sub" type="text"
                                                    value="{{ old('district_sub') }}" id="contact_district1">
                                                <option value="" selected="selected">Chọn Quận/Huyện</option>
                                            </select>
                                            @error('district_sub')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('district_sub')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="address_sub"
                                                   value="{{ old('address_sub') }}"
                                                   id="contact_diachi1" type="text"/>
                                            <label for="contact_diachi1">{{ __('Vui lòng nhập địa chỉ') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('address_sub')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('address_sub')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="mail" value="{{ old('mail') }}" id="contact_mail"
                                                   type="text"/>
                                            <label for="contact_mail">{{ trans('plugins/contact::contact.form_email') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('mail')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('mail')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="num_phone"
                                                   value="{{ old('num_phone') }}" id="contact_num_phone"/>
                                            <label for="contact_num_phone">{{ trans('plugins/contact::contact.form_phone') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('num_phone')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('num_phone')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="link_fb" value="{{ old('link_fb') }}"
                                                   id="contact_link_fb"/>
                                            <label for="contact_link_fb">{{ __('Facebook/Instagram') }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Thông tin nghề nghiệp --}}
                            <div class="col-lg-12">
                                <h2 class="problem">2.{{ __('Thông tin nghề nghiệp') }}</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="education"
                                                   value="{{ old('education') }}" id="contact_education"/>
                                            <label for="contact_education">{{ __('Học vấn chuyên môn') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('education')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('education')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="works" value="{{ old('works') }}"
                                                   id="contact_works"/>
                                            <label for="contact_works">{{ __('Số năm làm việc thực tế') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('works')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('works')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="work_place"
                                                   value="{{ old('work_place') }}" id="contact_work_place"/>
                                            <label for="contact_work_place">{{ __('Nơi công tác hiện nay') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('work_place')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('work_place')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="position"
                                                   value="{{ old('position') }}" id="contact_position"/>
                                            <label for="contact_position">{{ __('Chức vụ/ Vị trí/ Công việc chuyên môn') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('position')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('position')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <input class="contact-input" type="text" name="address_work" value="{{ old('address_work') }}"
                                           id="contact_working"/>
                                    <label for="contact_working">{{ __('Địa chỉ nơi công tác') }}
                                        <div class="msg text-danger">*</div>
                                    </label>
                                    @error('address_work')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('address_work')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <textarea name="degree" rows="4" id="contact_degree">{{ old('degree') }}</textarea>
                                    <label for="contact_degree">{{ __('Các Bằng cấp/ Chứng chỉ (nếu có)') }}</label>
                                    @error('degree')
                                    <span class="errors">{{ __('Vui lòng nhập thông tin này!') }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <textarea name="capacity" rows="4" id="contact_capacity">{{ old('capacity') }}</textarea>
                                    <label
                                            for="contact_capacity">{{ __('Năng lực/ Thế mạnh có thể đóng góp cho Hiệp hội (nếu có)') }}</label>
                                    @error('capacity')
                                    <span class="errors">{{ __('Vui lòng nhập thông tin này!') }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Giấy tờ liên quan --}}
                            <div class="col-md-12">
                                <h2 class="problem">3.{{ __('Các giấy tờ liên quan') }}
                                    <sup class="text-danger">*</sup>
                                </h2>
                                @if(has_field($page, 'tieu_de_hoi_vien_ca_nhan'))
                                    <i class="pb-4">{{get_field($page, 'tieu_de_hoi_vien_ca_nhan')}}</i>
                                @endif
                                @if(has_field($page, 'giay_to_lien_quan_hoi_vien_ca_nhan'))
                                    @foreach(get_field($page, 'giay_to_lien_quan_hoi_vien_ca_nhan')  as $k => $item)
                                        <span class="text-black">
                                            <a class="register_member" href="{{ asset('storage/' .get_sub_field($item, 'tep_tin')) }}" download="{{get_sub_field($item, 'tep_tin')}}">
                                                {{$k+1}}.{{get_sub_field($item, 'ten_file')}}<i> (nhấn vào để tải xuống)</i>
                                            </a>
                                            <br>
                                        </span>
                                    @endforeach
                                @endif
                                @if(has_field($page, 'giay_to_khac_cua_hoi_vien_ca_nhan'))
                                    @foreach(get_field($page, 'giay_to_khac_cua_hoi_vien_ca_nhan') as $k => $item)
                                        @if(has_sub_field($item, 'ten_giay_to'))
                                            <span class="text-black">
                                                {{$k+3}}.{{get_sub_field($item, 'ten_giay_to')}}
                                            </span>
                                        @endif
                                    @endforeach
                                    <br>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <input class="contact-input custom-file-inputt" type="file" name="file[]" id="contact_file" multiple="multiple"/>
                                    <label for="contact_file">{{__("Vui lòng tải lên tất cả các giấy tờ liên quan")}}</label>
                                    @error('file')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('file')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Mục đích tham gia hiệp hội --}}
                            <div class="col-md-12">
                                <h2 class="problem">4.{{ __("Mục đích tham gia hiệp hội") }}
                                    {{--                            <sup class="text-danger">*</sup>--}}
                                </h2>
                            </div>
                            <div class="col-md-12">
                                @if(has_field($page, 'muc_dich'))
                                    @foreach (get_field($page, 'muc_dich') as $key => $item)
                                        <div class="w-100 __body">
                                            <label class="checkbox">
                                    <span class="checkbox__input">
                                        <input type="checkbox" value="{{get_sub_field($item, 'ly_do')}}" name="purposes[]" @if(is_array(old('purposes')) && in_array(get_sub_field($item, 'ly_do'), old('purposes'))) checked @endif>
                                        <span class="checkbox__control">
                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                 aria-hidden="true" focusable="false">
                                                <path fill='none' stroke='currentColor' stroke-width='3'
                                                      d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                            </svg>
                                        </span>
                                    </span>
                                                @if(has_sub_field($item, 'ly_do'))
                                                    <span class="radio__label">{{get_sub_field($item, 'ly_do')}}</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="styled-input wide w-100">
                                    <input class="contact-input" type="text" name="purposes[]" value="{{get_old_activity_another((old('purposes') != null) ? old('purposes') : [], get_field($page, 'muc_dich'))}}"
                                           id="contact_purpose8"/>
                                    <label for="contact_purpose8">{{ __('Khác') }}</label>
                                    @error('purposes.0')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('purposes.0')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="w-100 __body __mr_check">
                                    <label class="checkbox">
                                <span class="checkbox__input">
                                    <input type="checkbox" name="assure" checked disabled>
                                    <span class="checkbox__control">
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' aria-hidden="true"
                                             focusable="false">
                                            <path fill='none' stroke='currentColor' stroke-width='3'
                                                  d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                        </svg>
                                    </span>
                                </span>
                                        <span class="radio__label __text_check">Tôi xin cam đoan:</span>
                                    </label>
                                    @if(has_field($page, 'cac_cam_ket'))
                                        <ul class="ul-cam-doan">
                                            @foreach (get_field($page, 'cac_cam_ket') as $key => $item)
                                                @if(has_sub_field($item, 'cam_ket'))
                                                    <li class="__text_li">{{get_sub_field($item, 'cam_ket')}}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if (setting('enable_captcha') && is_plugin_active('captcha'))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_robot"
                                               class="control-label">{{ trans('plugins/contact::contact.confirm_not_robot') }}</label>
                                        {!! Captcha::display('captcha') !!}
                                        {!! Captcha::script() !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <p>{!! trans('plugins/contact::contact.required_field') !!}</p>
                            </div>
                            <div class="col-lg-3 button-send-member">
                                <input value="{{ __('Gửi') }}" class="btn-lrg submit-btn" type="submit">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade {{ $tabActive == 'pills-profile' ? 'show active' : '' }}" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form action="{{route('submit-form-organize')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @if(session()->has('success_msg') || session()->has('error_msg') || isset($errors))
                                @if (session('msg'))
                                    <div class="col-md-12 pt-4">
                                        <div class="alert alert-{{session('type')}}" role="alert">{{session('msg')}}</div>
                                    </div>
                                @endif
                            @endif

                            {{-- Thông tin tổ chức --}}
                            <div class="col-md-12">
                                <h2 class="problem">1.{{ __('Tên tổ chức') }}</h2>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="name_vietnam" type="text"
                                                   value="{{ old('name_vietnam') }}"
                                                   id="contact_name_vietnam"/>
                                            <label for="contact_name_vietnam">{{__('Tên tiếng Việt')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('name_vietnam')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('name_vietnam')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="name_english" type="text"
                                                   value="{{ old('name_english') }}"
                                                   id="contact_name_english"/>
                                            <label for="contact_name_english">{{__('Tên tiếng Anh')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('name_english')
                                            <span class="errors">
                                                    <strong>
                                                        {{$errors->first('name_english')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="name_sub" type="text"
                                                   value="{{ old('name_sub') }}"
                                                   id="contact_name_sub"/>
                                            <label for="contact_name_sub">{{__('Tên viết tắt')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('name_sub')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('name_sub')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <label class="__focus" for="contact_issued_by">{{ __('Nơi cấp') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="issued_by" type="text" id="contact_issued_by">
                                                @if(!blank($provinces))
                                                    <option value="" selected="selected">Chọn Tỉnh/TP</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('issued_by') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('issued_by')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('issued_by')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="num_business" type="text"
                                                   value="{{ old('num_business') }}"
                                                   id="contact_num_business"/>
                                            <label for="contact_num_business">{{__('Quyết định thành lập/Giấy chứng nhận đăng ký doanh nghiệp số')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('num_business')
                                                <span class="errors">
                                                    <strong>{{$errors->first('num_business')}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="date_start_at" type="date"
                                                   value="{{ old('date_start_at') }}" id="contact_date_start_at"/>
                                            <label for="contact_date_start_at" class="__focus">{{ __('Ngày cấp lần đầu') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('date_start_at')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('date_start_at')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="date_at" type="date"
                                                   value="{{ old('date_at') }}" id="contact_date_at"/>
                                            <label for="contact_date_at" class="__focus">{{ __('Ngày cấp thay đổi') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('date_at')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('date_at')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="type_business" type="text"
                                                   value="{{ old('type_business') }}" id="contact_type_business"/>
                                            <label for="contact_type_business" class="__focus">{{ __('Loại hình doanh nghiệp') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('type_business')
                                            <span class="errors">
                                                    <strong>
                                                        {{$errors->first('type_business')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_pernament_main"
                                                   class="__focus">{{ __('Địa chỉ trụ sở chính') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="pernament_main" type="text" id="contact_pernament_main">
                                                <option value="">Chọn Tỉnh/TP</option>
                                                @if(!blank($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('pernament_main') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('pernament_main')
                                            <span class="errors">
                                                <strong>
                                                    {{$errors->first('pernament_main')}}
                                                </strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_district_main" class="__focus">{{ __('Quận/Huyện') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            <select class="contact-input" name="district_main" type="text"
                                                    value="{{ old('district_main') }}" id="contact_district_main">
                                                <option value="" selected="selected">Chọn Quận/Huyện</option>
                                            </select>
                                            @error('district_main')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('district_main')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="address_main" value="{{ old('address_main') }}"
                                                   id="contact_address_main" type="text"/>
                                            <label for="contact_address_main">{{ __('Vui lòng nhập địa chỉ') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('address_main')
                                            <span class="errors">
                                        <strong>
                                            {{$errors->first('address_main')}}
                                        </strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_pernament_sub"
                                                   class="__focus">{{ __('Địa chỉ giao dịch(nếu có)') }}
                                            </label>
                                            <select class="contact-input" name="pernament_sub" type="text"
                                                    value="{{ old('pernament_sub') }}" id="contact_pernament_sub">
                                                <option value="" selected="selected">Chọn Tỉnh/TP</option>
                                                @if(!blank($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->name}}" {{(old('pernament_sub') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <label for="contact_district_sub" class="__focus">{{ __('Quận/Huyện') }}
                                            </label>
                                            <select class="contact-input" name="district_sub" type="text"
                                                    value="{{ old('district_sub') }}" id="contact_district_sub">
                                                <option value="" selected="selected">Chọn Quận/Huyện</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input padding-input" name="address_sub"
                                                   value="{{ old('address_sub') }}"
                                                   id="contact_address_sub" type="text"/>
                                            <label for="contact_address_sub">{{ __('Vui lòng nhập địa chỉ') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="phone" value="{{ old('phone') }}" id="contact_phone"
                                                   type="text"/>
                                            <label for="contact_phone">{{__('Số điện thoại')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('phone')
                                            <span class="errors">
                                                <strong>
                                                    {{$errors->first('phone')}}
                                                </strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="email"
                                                   value="{{ old('email') }}" id="contact_email"/>
                                            <label for="contact_email">{{__('Email')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('email')
                                            <span class="errors">
                                                <strong>
                                                    {{$errors->first('email')}}
                                                </strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="link_web" value="{{ old('link_web') }}"
                                                   id="contact_link_web"/>
                                            <label for="contact_link_web">{{ __('Website') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('link_web')
                                            <span class="errors">
                                                <strong>
                                                    {{$errors->first('link_web')}}
                                                </strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="fanpage" value="{{ old('fanpage') }}" id="contact_fanpage"
                                                   type="text"/>
                                            <label for="contact_fanpage">{{__('Fanpage')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('fanpage')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('fanpage')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" name="representative" value="{{ old('representative') }}" id="contact_representative"
                                                   type="text"/>
                                            <label for="contact_representative">{{__('Người đại diện')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('representative')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('representative')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="position"
                                                   value="{{ old('position') }}" id="contact_position"/>
                                            <label for="contact_position">{{__('Chức vụ')}}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('position')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('position')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Thông tin người đại diện --}}
                            <div class="col-lg-12">
                                <h2 class="problem">2.{{ __('Người đại diện tổ chức tham gia Hiệp hội') }}</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="name_member"
                                                   value="{{ old('name_member') }}" id="contact_name_member"/>
                                            <label for="contact_name_member">{{ __('Họ và tên') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('name_member')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('name_member')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="position_member"
                                                   value="{{ old('position_member') }}" id="contact_position_member"/>
                                            <label for="contact_position_member">{{ __('Chức vụ') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('position_member')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('position_member')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="email_member"
                                                   value="{{ old('email_member') }}" id="contact_email_member"/>
                                            <label for="contact_email_member">{{ __('Email') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('email_member')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('email_member')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="text" name="phone_member" value="{{ old('phone_member') }}"
                                                   id="contact_phone_member"/>
                                            <label for="contact_phone_member">{{ __('Số điện thoại') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('phone_member')
                                            <span class="errors">
                                                <strong>
                                                    {{$errors->first('phone_member')}}
                                                </strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Ngành nghề kinh doanh --}}
                            <div class="col-md-12">
                                <h2 class="problem">3.{{ __('Các ngành nghề kinh doanh') }}</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <textarea name="career_main" rows="4" id="contact_career_main">{{ old('career_main') }}</textarea>
                                    <label for="contact_career_main">{{ __('Sản phẩm, dịch vụ chính') }}
                                        <div class="msg text-danger">*</div>
                                    </label>
                                    @error('career_main')
                                    <span class="errors">
                                        <strong>
                                            {{$errors->first('career_main')}}
                                        </strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <textarea name="logo_main" rows="3" id="contact_logo_main">{{ old('logo_main') }}</textarea>
                                    <label for="contact_logo_main">{{ __('Tên thương hiệu/ Nhãn hiệu sản phẩm, dịch vụ chính (nếu có)') }}</label>
                                    @error('logo_main')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('logo_main')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <label for="contact_marketing_main" class="__focus">{{ __('Thị trường hoạt động chính (tỉnh/thành): ') }}
                                        <div class="msg text-danger">*</div>
                                    </label>
                                    <select class="contact-input" name="marketing_main" type="text"
                                            value="{{ old('marketing_main') }}" id="contact_marketing_main">
                                        <option value="" selected="selected">Chọn Tỉnh/TP</option>
                                        @if(!blank($provinces))
                                            @foreach($provinces as $province)
                                                <option value="{{$province->name}}" {{(old('marketing_main') == $province->name)  ? 'selected' : ''}}>{{$province->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('marketing_main')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('marketing_main')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <textarea name="shop" rows="3" id="contact_shop">{{ old('shop') }}</textarea>
                                    <label for="contact_shop">{{ __('Có Chi nhánh/ Văn phòng giao dịch tại các tỉnh/thành') }}
                                        <div class="msg text-danger">*</div>
                                    </label>
                                    @error('shop')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('shop')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="number" name="total_staff"
                                                   value="{{ old('total_staff') }}" id="contact_total_staff"/>
                                            <label for="contact_total_staff">{{ __('Tổng số CBNV toàn đơn vị') }}
                                                <div class="msg text-danger">*</div>
                                            </label>
                                            @error('total_staff')
                                                <span class="errors">
                                                    <strong>
                                                        {{$errors->first('total_staff')}}
                                                    </strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="styled-input wide w-100">
                                            <input class="contact-input" type="number" name="total_staff_tech"
                                                   value="{{ old('total_staff_tech') }}" id="contact_total_staff_tech"/>
                                            <label for="contact_total_staff_tech">{{ __('Số lượng nhân viên kỹ thuật thang máy (nếu có)') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Hoạt động chính --}}
                            <div class="col-md-12 pt-3">
                                <h2 class="problem">4.{{ __('Các mảng hoạt động của đơn vị (có thể gồm nhiều hoạt động):') }}
                                </h2>
                            </div>
                            <div class="col-lg-12 activity-main">
                                @if(has_field($page, 'tieu_de_hoat_dong'))
                                    @php
                                        $dem = count(has_field($page, 'tieu_de_hoat_dong'));
                                        $left = round($dem/2, 0) - 1;
                                    @endphp
                                    <div class="activity-main__left">
                                        @foreach (get_field($page, 'tieu_de_hoat_dong') as $key => $item)
                                            @if($key <= $left)
                                                <div class="w-100 __body">
                                                    <label class="checkbox">
                                                    <span class="checkbox__input">
                                                        <input type="checkbox" value="{{get_sub_field($item, 'ten_hoat_dong')}}" name="activity[]" @if(is_array(old('activity')) && in_array(get_sub_field($item, 'ten_hoat_dong'), old('activity'))) checked @endif>
                                                        <span class="checkbox__control">
                                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                                aria-hidden="true" focusable="false">
                                                                <path fill='none' stroke='currentColor' stroke-width='3'
                                                                    d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                        @if(has_sub_field($item, 'ten_hoat_dong'))
                                                            <span class="radio__label">{{get_sub_field($item, 'ten_hoat_dong')}}</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="activity-main__right">
                                        @foreach (get_field($page, 'tieu_de_hoat_dong') as $key => $item)
                                            @if($key > $left)
                                                <div class="w-100 __body">
                                                    <label class="checkbox">
                                                    <span class="checkbox__input">
                                                        <input type="checkbox" value="{{get_sub_field($item, 'ten_hoat_dong')}}" name="activity[]" @if(is_array(old('activity')) && in_array(get_sub_field($item, 'ten_hoat_dong'), old('activity'))) checked @endif>
                                                        <span class="checkbox__control">
                                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                                aria-hidden="true" focusable="false">
                                                                <path fill='none' stroke='currentColor' stroke-width='3'
                                                                    d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                        @if(has_sub_field($item, 'ten_hoat_dong'))
                                                            <span class="radio__label">{{get_sub_field($item, 'ten_hoat_dong')}}</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <input class="contact-input" type="text" name="activity[]" 
                                        value="{{get_old_activity_another((old('activity') != null) ? old('activity') : [], get_field($page, 'tieu_de_hoat_dong'))}}"
                                           id="contact_purpose8"/>
                                    <label for="contact_purpose8">{{ __('Khác') }}</label>
                                    @error('activity.0')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('activity.0')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h2 class="problem">5.{{ __('Tình hình hoạt động 3 năm gần nhất') }}</h2>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-right">
                                    @if(has_field($page, 'don_vi_tinh'))
                                        <i>(ĐVT: {{get_field($page, 'don_vi_tinh')}})</i>    
                                    @endif
                                </div>
                                <div id="vue" >
                                    <form-year-tabs inline-template :old="{{ json_encode(old('activity_for_latest_years') ?? []) }}">
                                        <table class="table table-bordered text-center">
                                            @php $old = old('activity_for_latest_years') ?? [] @endphp
                                            <thead>
                                                <tr>
                                                    <th class="text-center" scope="col">{{__("Hạng mục")}}</th>
                                                    <th class="year text-center" scope="col">
                                                        <input v-model="year1" class="year--item" type="text" placeholder="Năm 20..">
                                                    </th>
                                                    <th class="year text-center" scope="col">
                                                        <input v-model="year2" class="year--item" type="text" placeholder="Năm 20..">
                                                    </th>
                                                    <th class="year text-center" scope="col">
                                                        <input v-model="year3" class="year--item" type="text" placeholder="Năm 20..">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(has_field($page, 'cac_hang_muc'))
                                                    @foreach(get_field($page, 'cac_hang_muc') as $item)
                                                        <tr>
                                                            @if(has_sub_field($item, 'ten_hang_muc'))
                                                                <td class="text-left">{{get_sub_field($item, 'ten_hang_muc')}}</td>
                                                            @endif

                                                            <td><input class="value--item" type="text" 
                                                                value="{{ isset(array_values($old)[0][get_sub_field($item, 'truong_database')]) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                                                :name="year1 ? `activity_for_latest_years[${year1}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                            <td><input class="value--item" type="text" 
                                                                value="{{ isset(array_values($old)[1][get_sub_field($item, 'truong_database')]) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}"  
                                                                :name="year2 ? `activity_for_latest_years[${year2}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                            <td><input class="value--item" type="text" 
                                                                value="{{ isset(array_values($old)[2][get_sub_field($item, 'truong_database')]) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                                                :name="year3 ? `activity_for_latest_years[${year3}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if(has_field($page, 'tieu_de_san_luong_thang'))
                                                    <tr>
                                                        <td class="san-luong-than text-left" colspan="4">{!! get_field($page, 'tieu_de_san_luong_thang') !!}</td>
                                                    </tr>
                                                @endif
                                                @if(has_field($page, 'san_luong_thang'))
                                                    @foreach(get_field($page, 'san_luong_thang') as $item)
                                                        <tr>
                                                            @if(has_sub_field($item, 'loai_thang_may'))
                                                                <td class="text-left">{{has_sub_field($item, 'loai_thang_may')}}</td>
                                                            @endif

                                                            <td><input class="value--item" type="text" 
                                                                value="{{ (isset(array_values($old)[0]) && isset(array_values($old)[0][get_sub_field($item, 'truong_database')])) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                                                :name="year1 ? `activity_for_latest_years[${year1}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                            <td><input class="value--item" type="text" 
                                                                value="{{ isset(array_values($old)[1][get_sub_field($item, 'truong_database')]) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                                                :name="year2 ? `activity_for_latest_years[${year2}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                            <td><input class="value--item" type="text" 
                                                                value="{{ isset(array_values($old)[2][get_sub_field($item, 'truong_database')]) ? array_values($old)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                                                :name="year3 ? `activity_for_latest_years[${year3}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </form-year-tabs>
                                </div>
                            </div>
                            {{-- Mục đích tham gia hiệp hội --}}
                            <div class="col-md-12">
                                <h2 class="problem">6.{{ __('Mục đích tham gia hiệp hội') }}
                                    <sup class="text-danger">*</sup>
                                </h2>
                            </div>
                            <div class="col-lg-12 activity-main">
                                <div class="activity-main__left">
                                    <div class="activity-main__left-title pb-3">Nhu cầu của đơn vị</div>
                                    @if(has_field($page, 'nhu_cau_cua_don_vi'))
                                        @foreach(get_field($page, 'nhu_cau_cua_don_vi') as $item)
                                            @if(has_sub_field($item, 'nhu_cau'))
                                                <div class="w-100 __body">
                                                    <label class="checkbox">
                                                    <span class="checkbox__input">
                                                        <input type="checkbox" value="{{get_sub_field($item, 'nhu_cau')}}" name="purpose[nhu_cau][]" @if(is_array(old('purpose')) && in_array(get_sub_field($item, 'nhu_cau'), old('purpose')['nhu_cau'])) checked @endif>
                                                        <span class="checkbox__control">
                                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                                aria-hidden="true" focusable="false">
                                                                <path fill='none' stroke='currentColor' stroke-width='3'
                                                                    d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                        <span class="radio__label item--nhucau">{{get_sub_field($item, 'nhu_cau')}}</span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="activity-main__right ">
                                    <div class="activity-main__left-title pb-3">Khả năng đóng góp cho hiệp hội</div>
                                    @if(has_field($page, 'kha_nang_dong_gop_cho_hiep_hoi'))
                                        @foreach(get_field($page, 'kha_nang_dong_gop_cho_hiep_hoi') as $item)
                                            @if(has_sub_field($item, 'kha_nang'))
                                                <div class="w-100 __body">
                                                    <label class="checkbox">
                                                    <span class="checkbox__input">
                                                        <input type="checkbox" value="{{get_sub_field($item, 'kha_nang')}}" name="purpose[kha_nang][]" @if(is_array(old('purpose')) && in_array(get_sub_field($item, 'kha_nang'), old('purpose')['kha_nang'])) checked @endif>
                                                        <span class="checkbox__control">
                                                            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'
                                                                aria-hidden="true" focusable="false">
                                                                <path fill='none' stroke='currentColor' stroke-width='3'
                                                                    d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                        <span class="radio__label item--nhucau">{{get_sub_field($item, 'kha_nang')}}</span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        <div class="styled-input wide w-100">
                                            <input 
                                                class="contact-input" type="text" name="purpose[kha_nang][]" 
                                                value="{{ get_old_purpose_another(isset(old('purpose')['kha_nang']) ? old('purpose')['kha_nang'] : [], get_field($page, 'kha_nang_dong_gop_cho_hiep_hoi')) }}"
                                                id="contact_purpose8"/>
                                            <label for="contact_purpose8">{{ __('Khác') }}</label>
                                            
                                            <input 
                                                class="contact-input" type="text" name="purpose[nhu_cau][]" 
                                                value=""
                                                hidden/>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                @error('purpose.nhu_cau.0')
                                    <span class="errors">
                                        <strong>
                                            {{$errors->first('purpose.nhu_cau.0')}}
                                        </strong>
                                    </span>
                                @enderror
                                @error('purpose.kha_nang.0')
                                    <span class="errors">
                                        <strong>
                                            {{$errors->first('purpose.kha_nang.0')}}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Giấy tờ liên quan --}}
                            <div class="col-md-12">
                                <h2 class="problem">7.{{ __('Các giấy tờ liên quan') }}
                                    <sup class="text-danger">*</sup>
                                </h2>
                                @if(has_field($page, 'tieu_de_hoi_vien_to_chuc'))
                                    <i class="pb-4">{{get_field($page, 'tieu_de_hoi_vien_to_chuc')}}</i>
                                @endif
                                @if(has_field($page, 'giay_to_lien_quan_hoi_vien_to_chuc'))
                                    @foreach(get_field($page, 'giay_to_lien_quan_hoi_vien_to_chuc')  as $k => $item)
                                        <span class="text-black">
                                            <a class="register_member" href="{{ asset('storage/' .get_sub_field($item, 'tep_tin')) }}" download="{{get_sub_field($item, 'tep_tin')}}">
                                                {{$k+1}}.{{get_sub_field($item, 'ten_file')}}<i> (nhấn vào để tải xuống)</i>
                                            </a>
                                            <br>
                                        </span>
                                    @endforeach
                                @endif
                                @if(has_field($page, 'giay_to_khac_cua_hoi_vien_to_chuc'))
                                    @foreach(get_field($page, 'giay_to_khac_cua_hoi_vien_to_chuc') as $k => $item)
                                        @if(has_sub_field($item, 'ten_giay_to'))
                                            <span class="text-black">
                                                {{$k+3}}.{{get_sub_field($item, 'ten_giay_to')}}
                                            </span>
                                        @endif
                                    @endforeach
                                    <br>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="styled-input wide w-100">
                                    <input class="contact-input custom-file-inputt" type="file" name="file[]" id="contact_file" multiple="multiple"/>
                                    <label for="contact_file">{{__("Vui lòng tải lên các giấy tờ liên quan")}}</label>
                                    @error('file')
                                        <span class="errors">
                                            <strong>
                                                {{$errors->first('file')}}
                                            </strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="w-100 __body __mr_check">
                                    <label class="checkbox">
                                <span class="checkbox__input">
                                    <input type="checkbox" name="assure" checked disabled>
                                    <span class="checkbox__control">
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' aria-hidden="true"
                                             focusable="false">
                                            <path fill='none' stroke='currentColor' stroke-width='3'
                                                  d='M1.73 12.91l6.37 6.37L22.79 4.59'/>
                                        </svg>
                                    </span>
                                </span>
                                        <span class="radio__label __text_check">Tôi xin cam đoan:</span>
                                    </label>
                                    @if(has_field($page, 'cac_cam_ket'))
                                        <ul class="ul-cam-doan">
                                            @foreach (get_field($page, 'cac_cam_ket') as $key => $item)
                                                @if(has_sub_field($item, 'cam_ket'))
                                                    <li class="__text_li">{{get_sub_field($item, 'cam_ket')}}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if (setting('enable_captcha') && is_plugin_active('captcha'))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_robot"
                                               class="control-label">{{ trans('plugins/contact::contact.confirm_not_robot') }}</label>
                                        {!! Captcha::display('captcha') !!}
                                        {!! Captcha::script() !!}
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <p>{!! trans('plugins/contact::contact.required_field') !!}</p>
                            </div>
                            <div class="col-lg-3 button-send-member">
                                <input value="{{ __('Gửi') }}" class="btn-lrg submit-btn" type="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop