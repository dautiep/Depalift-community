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
        vertical-align: baseline!important;
    }
    .dataTables_wrapper .td-table-sub{
        vertical-align: unset !important;
    }
    .td-table-sub{
        width: 50%;
    }
    .dataTables_wrapper .td-table-sub-title{
        width: 40%;
        padding-left: 0px !important;
        vertical-align: baseline!important;
    }
</style>
<table class="table">
    <tbody>
    <tr>
        <th class="info-table">THÔNG TIN TỔ CHỨC</th>
        <th class="info-table">THÔNG TIN NGƯỜI ĐẠI DIỆN</th>
    </tr>
    <tr class="border-none">
        <td class="border-none td-table-sub">
            <table>
                <tbody>
                    <tr>
                        <td class="info-table td-table-sub-title">Tên tiếng Việt:</td>
                        <td class="info-table">{{$data->name_vietnam}}</td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Tên tiếng Anh:</td>
                        <td class="info-table">
                            {{$data->name_english}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Tên viết tắt:</td>
                        <td class="info-table">
                            {{$data->name_sub}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Quyết định thành lập:</td>
                        <td class="info-table">
                            {{$data->num_business}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Nơi cấp:</td>
                        <td class="info-table">
                            {{$data->issued_by}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Ngày cấp:</td>
                        <td class="info-table">
                            {{date_format(date_create($data->date_at), 'd-m-Y')}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Loại hình doanh nghiệp:</td>
                        <td class="info-table">
                            {{$data->type_business}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Địa chỉ trụ sở chính:</td>
                        <td class="info-table">
                            {{$data->address_main}}, {{$data->district_main}}, {{$data->pernament_main}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Địa chỉ liên hệ:</td>
                        <td class="info-table">
                            {{$data->address_sub}}, {{$data->district_sub}}, {{$data->pernament_sub}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Số điện thoại:</td>
                        <td class="info-table">
                            {{$data->phone}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Số fax:</td>
                        <td class="info-table">
                            {{$data->fax}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Website:</td>
                            @if(!blank($data->link_web))
                            <td class="info-table">
                                {{$data->link_web}}
                            </td>
                            @else
                                <td class="info-table text-danger">
                                    Không có thông tin
                                </td>
                            @endif
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Người đại diện:</td>
                        <td class="info-table">
                            {{$data->representative}}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-table td-table-sub-title">Chức vụ:</td>
                        <td class="info-table">
                            {{$data->position}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td class="border-none td-table-sub">
            <table class="table-work">
                <tbody>
                <tr>
                    <td class="info-table td-table-sub-title">Họ tên:</td>
                    <td class="info-table">{{$data->name_member}}</td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Chức vụ:</td>
                    <td class="info-table">{{$data->position_member}} năm</td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Số điện thoại:</td>
                    <td class="info-table">
                        {{$data->phone_member}}
                    </td>
                </tr>
                <tr>
                    <td class="info-table td-table-sub-title">Vị trí:</td>
                    <td class="info-table">
                        {{$data->position}}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>