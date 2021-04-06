<style>
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
    $organizeMember = \Platform\MemberPersonal\Models\MemberPersonal::where('id', request()->route('member_personal'))->first();
    $purposes = json_decode($organizeMember->purpose, true);
@endphp
<div class="activity-main-edit-purpose">
    <div class="activity-main-edit-purpose__left">
        @if(has_field($page, 'muc_dich'))
            @foreach(get_field($page, 'muc_dich') as $item)
                @if(has_sub_field($item, 'ly_do'))
                    <div class="w-100 __body">
                        <label class="checkbox">
                        <span class="checkbox__input">
                            <input type="checkbox" value="{{get_sub_field($item, 'ly_do')}}" name="purposes[]" @if(is_array($purposes) && in_array(get_sub_field($item, 'ly_do'), $purposes)) checked @endif>
                            <span class="checkbox__control">
                            </span>
                        </span>
                            <span class="radio__label item--nhucau">{{get_sub_field($item, 'ly_do')}}</span>
                        </label>
                    </div>
                @endif
            @endforeach
            <div class="styled-input wide w-100">
                <input 
                    class="contact-input-other" type="text" name="purposes[]" 
                    value="{{ get_old_purpose_another(isset($purposes) ? $purposes : [], get_field($page, 'muc_dich')) }}"
                    id="contact_purpose8"
                    placeholder="khác"/>
            </div>
        @endif
    </div>
</div>