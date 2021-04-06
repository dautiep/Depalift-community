<style>
    table .year{
        width: 25%;
        text-align: center;
    }
    .year--item{
        border: none;
        font-weight: bold;
        width: 100% !important;
        text-align: center;
    }
    .value--item{
        border: none;
        width: 100% !important;
        text-align: center;
    }
    .san-luong-than{
        font-weight: bold;
    }
    .outline:focus{
        outline: none;
    }
    .border-top{
        border-top: 1px solid #c4cdd5;
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
    if(!blank($organizeMember->activity_for_latest_years) && $organizeMember->activity_for_latest_years!= 'null'){
        $activities_last = json_decode($organizeMember->activity_for_latest_years, true);
        $years = array_keys($activities_last);
    }
@endphp
<div class="col-lg-12 pb-3">
    <div class="text-right">
        @if(has_field($page, 'don_vi_tinh'))
            <i>(ĐVT: {{get_field($page, 'don_vi_tinh')}})</i>    
        @endif
    </div>
    <div id="vue" >
        <form-year-tabs inline-template :old="{{ json_encode($activities_last ?? []) }}">
            <table class="table table-bordered text-center">
                @php $old = $activities_last ?? [] @endphp
                <thead>
                    <tr>
                        <th class="text-center" scope="col">{{__("Hạng mục")}}</th>
                        <th class="year text-center" scope="col">
                            <input v-model="year1" class="year--item outline" value="{{$years[0] ?? ''}}" type="text" placeholder="Năm 20..">
                        </th>
                        <th class="year text-center" scope="col">
                            <input v-model="year2" class="year--item outline" value="{{$years[1] ?? ''}}" type="text" placeholder="Năm 20..">
                        </th>
                        <th class="year text-center" scope="col">
                            <input v-model="year3" class="year--item outline" value="{{$years[2] ?? ''}}" type="text" placeholder="Năm 20..">
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
                                
                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[0][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                    :name="year1 ? `activity_for_latest_years[${year1}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                </td>
                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[1][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[1][get_sub_field($item, 'truong_database')] : '' }}"  
                                    :name="year2 ? `activity_for_latest_years[${year2}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                </td>
                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[2][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[2][get_sub_field($item, 'truong_database')] : '' }}" 
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

                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[0]) && isset(array_values($activities_last)[0][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[0][get_sub_field($item, 'truong_database')] : '' }}" 
                                    :name="year1 ? `activity_for_latest_years[${year1}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                </td>
                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[1][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[1][get_sub_field($item, 'truong_database')] : '' }}" 
                                    :name="year2 ? `activity_for_latest_years[${year2}]` + `[{{get_sub_field($item, 'truong_database')}}]` : ''" placeholder="">
                                </td>
                                <td><input class="value--item outline" type="text" 
                                    value="{{ (isset($activities_last) && isset(array_values($activities_last)[2][get_sub_field($item, 'truong_database')])) ? array_values($activities_last)[2][get_sub_field($item, 'truong_database')] : '' }}" 
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