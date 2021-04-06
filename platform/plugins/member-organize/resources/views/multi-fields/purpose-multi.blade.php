<style>
    .activity-main-edit-purpose{
        display: flex;
        flex-direction: row;
        flex: 1;
    }
    .activity-main-edit-purpose__left{
        flex: 50%;
    }

    .activity-main-edit-purpose__right{
        flex: 50%;
    }
    .contact-input-other{
        width: 100%;
        padding: .55rem 1.15rem;
        border: 1px solid #c4cdd5;
    }
    .contact-input-other:focus{
        border: 1px solid #c4cdd5;
        border-radius: 4px;
    }
</style>
@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    @include('core/base::forms.partials.help-block')
@endif

@include('core/base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
@php
    $page = isset($page) && !blank($page) ? $page : \SlugHelper::getSlug('dang-ky-hoi-vien-truc-tuyen', null, \Platform\Page\Models\Page::class)->reference ?? null;
    $organizeMember = \Platform\MemberOrganize\Models\MemberOrganize::where('id', request()->route('member_organize'))->first();
    $purposes = json_decode($organizeMember->purpose, true);
@endphp
<div class="col-lg-12 activity-main-edit-purpose">
    <div class="activity-main-edit-purpose__left">
        <div class="activity-main-edit-purpose__left-title pb-3">Nhu cầu của đơn vị</div>
        @if(has_field($page, 'nhu_cau_cua_don_vi'))
            @foreach(get_field($page, 'nhu_cau_cua_don_vi') as $item)
                @if(has_sub_field($item, 'nhu_cau'))
                    <div class="w-100 __body">
                        <label class="checkbox">
                        <span class="checkbox__input">
                            <input type="checkbox" value="{{get_sub_field($item, 'nhu_cau')}}" name="purpose[nhu_cau][]" @if(is_array($purposes) && in_array(get_sub_field($item, 'nhu_cau'), $purposes['nhu_cau'])) checked @endif>
                            <span class="checkbox__control">
                            </span>
                        </span>
                            <span class="radio__label item--nhucau">{{get_sub_field($item, 'nhu_cau')}}</span>
                        </label>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div class="activity-main-edit-purpose__right ">
        <div class="activity-main-edit-purpose__left-title pb-3">Khả năng đóng góp cho hiệp hội</div>
        @if(has_field($page, 'kha_nang_dong_gop_cho_hiep_hoi'))
            @foreach(get_field($page, 'kha_nang_dong_gop_cho_hiep_hoi') as $item)
                @if(has_sub_field($item, 'kha_nang'))
                    <div class="w-100 __body">
                        <label class="checkbox">
                        <span class="checkbox__input">
                            <input type="checkbox" value="{{get_sub_field($item, 'kha_nang')}}" name="purpose[kha_nang][]" @if(is_array($purposes) && in_array(get_sub_field($item, 'kha_nang'), $purposes['kha_nang'])) checked @endif>
                            <span class="checkbox__control">
                            </span>
                        </span>
                            <span class="radio__label item--nhucau">{{get_sub_field($item, 'kha_nang')}}</span>
                        </label>
                    </div>
                @endif
            @endforeach
            
            <div class="styled-input wide w-100">
                <input 
                    class="contact-input-other" type="text" name="purpose[kha_nang][]" 
                    value="{{ get_old_purpose_another(isset($purposes['kha_nang']) ? $purposes['kha_nang'] : [], get_field($page, 'kha_nang_dong_gop_cho_hiep_hoi')) }}"
                    id="contact_purpose8"
                    placeholder="khác"/>
                <input 
                    class="contact-input-other" type="text" name="purpose[nhu_cau][]" 
                    value="" hidden/>
            </div>
        @endif
    </div>
</div>