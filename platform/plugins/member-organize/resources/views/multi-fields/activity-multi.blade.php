<style>
    .activity-main-edit{
        display: flex;
        flex-direction: row;
        flex: 1;
    }
    .activity-main-edit__left{
        flex: 50%;
    }

    .activity-main-edit__right{
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
    $activities = json_decode($organizeMember->activity);
@endphp
<div class="col-lg-12 activity-main-edit">
    @if(has_field($page, 'tieu_de_hoat_dong'))
        @php
            $dem = count(has_field($page, 'tieu_de_hoat_dong'));
            $left = round($dem/2, 0) - 1;
        @endphp
        <div class="activity-main-edit__left">
            @foreach (get_field($page, 'tieu_de_hoat_dong') as $key => $item)
                @if($key <= $left)
                    <div class="w-100 __body">
                        <label class="checkbox">
                        <span class="checkbox__input">
                            <input type="checkbox" value="{{get_sub_field($item, 'ten_hoat_dong')}}" name="activity[]" @if(is_array($activities) && in_array(get_sub_field($item, 'ten_hoat_dong'), $activities)) checked @endif>
                            <span class="checkbox__control">
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
        <div class="activity-main-edit__right">
            @foreach (get_field($page, 'tieu_de_hoat_dong') as $key => $item)
                @if($key > $left)
                    <div class="w-100 __body">
                        <label class="checkbox">
                        <span class="checkbox__input">
                            <input type="checkbox" value="{{get_sub_field($item, 'ten_hoat_dong')}}" name="activity[]" @if(is_array($activities) && in_array(get_sub_field($item, 'ten_hoat_dong'), $activities)) checked @endif>
                            <span class="checkbox__control">
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
<div class="col-lg-12 pt-3 pb-3">
    <div class="styled-input wide w-100">
        <input class="contact-input-other" type="text" name="activity[]" value="{{end($activities)}}"
               id="contact_purpose8" placeholder="khác"/>
    </div>
</div>
