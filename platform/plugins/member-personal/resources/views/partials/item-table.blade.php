<style>
    .table-striped tbody tr:nth-of-type(odd){
        background-color: unset !important;
    }
    .table-hover tbody tr:hover{
        background-color: unset !important;
    }
    .info-table{
        text-align: left !important;
        border: none !important;
    }
    .dataTables_wrapper .td-table-sub{
        vertical-align: unset !important;
    }
    .td-table-sub{
        width: 50%;
    }
    .td-table-sub-title{
        width: 40%;
    }
</style>
<table class="table">
    <tbody>
    <tr>
        <th class="info-table">THÔNG TIN CÁ NHÂN</th>
        <th class="info-table">THÔNG TIN CÔNG VIỆC</th>
    </tr>
    <tr class="border-none">
        <td class="border-none td-table-sub">
            <table>
                <tbody>
                    <tr>
                        <td class="info-table td-table-sub-title">Họ tên:</td>
                        <td class="info-table">{{$data->name}}</td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Giới tính:</td>
                        <td class="info-table">
                            @if($data->sex == 0)
                                Nam
                            @elseif($data->sex == 1)
                                Nữ
                            @else
                                Giới tính khác
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Ngày sinh:</td>
                        <td class="info-table">
                            {{date_format(date_create($data->birth_day), 'd-m-Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Nơi sinh:</td>
                        <td class="info-table">
                            {{$data->place_birth}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Quốc tịch:</td>
                        <td class="info-table">
                            {{$data->country}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Tôn giáo:</td>
                        <td class="info-table">
                            {{$data->religion}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">CMND:</td>
                        <td class="info-table">
                            {{$data->identify}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Ngày cấp:</td>
                        <td class="info-table">
                            {{date_format(date_create($data->date_range), 'd-m-Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Nơi cấp:</td>
                        <td class="info-table">
                            {{$data->issued_by}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Địa chỉ thường trú:</td>
                        <td class="info-table">
                            {{$data->address_main}}, {{$data->district_main}}, {{$data->pernament_main}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Địa chỉ hiện tại:</td>
                        <td class="info-table">
                            {{$data->address_sub}}, {{$data->district_sub}}, {{$data->pernament_sub}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Địa chỉ email:</td>
                        <td class="info-table">
                            {{$data->mail}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Số điện thoại:</td>
                        <td class="info-table">
                            {{$data->num_phone}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Link facebook:</td>
                            @if(!blank($data->link_fb))
                            <td class="info-table">
                                {{$data->link_fb}}
                            </td>
                            @else
                                <td class="info-table text-danger">
                                    Không có thông tin
                                </td>
                            @endif
                    </tr>
                </tbody>
            </table>
        </td>
        <td class="border-none td-table-sub">
            <table class="table-work">
                <tbody>
                <tr>
                    <td class="info-table td-table-sub-title">Học vấn chuyên môn:</td>
                    <td class="info-table">{{$data->education}}</td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Số năm làm việc:</td>
                    <td class="info-table">{{$data->works}} năm</td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Nơi công tác hiện tại:</td>
                    <td class="info-table">
                        {{$data->work_place}}
                    </td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Vị trí:</td>
                    <td class="info-table">
                        {{$data->position}}
                    </td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Địa chỉ công ty:</td>
                    <td class="info-table">
                        {{$data->address_work}}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>