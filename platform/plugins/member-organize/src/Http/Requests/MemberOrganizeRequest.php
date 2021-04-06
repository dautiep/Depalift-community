<?php

namespace Platform\MemberOrganize\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MemberOrganizeRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_vietnam'   => 'required',
            'name_english'   => 'required',
            'name_sub'   => 'required',
            'num_business'   => 'required',
            'issued_by'   => 'required',
            'date_start_at'   => 'required|before:tomorrow',
            'date_at'   => 'required|before:tomorrow',
            'type_business'   => 'required',
            'pernament_main'   => 'required',
            'district_main'   => 'required',
            'address_main'   => 'required',
            'pernament_sub'   => 'required',
            'district_sub'   => 'required',
            'address_sub'   => 'required',
            'email'         => [
                'required',
                'email',
                Rule::unique('app_member_organizes', 'id')->where(function($q) {
                    $q->when(!blank($this->route('member_organize')), function($sq) {
                        $sq->where('email', request()->phone)->where('id', '!=', $this->route('member_organize'));
                    });
                })
            ],
            'phone'   => [
                'required',
                'numeric',
                Rule::unique('app_member_organizes', 'id')->where(function($q) {
                    $q->when(!blank($this->route('member_organize')), function($sq) {
                        $sq->where('phone', request()->phone)->where('id', '!=', $this->route('member_organize'));
                    });
                })
            ],
            'link_web'   => 'required',
            'fanpage'    => 'required',
            'representative'   => 'required',
            'position'   => 'required',
            'name_member'   => 'required',
            'position_member'   => 'required',
            'phone_member'   => [
                'required',
                'numeric',
                Rule::unique('app_member_organizes', 'id')->where(function($q) {
                    $q->when(!blank($this->route('member_organize')), function($sq) {
                        $sq->where('phone_member', request()->phone_member)->where('id', '!=', $this->route('member_organize'));
                    });
                })
            ],
            'email_member'         => [
                'required',
                'email',
                Rule::unique('app_member_organizes', 'id')->where(function($q) {
                    $q->when(!blank($this->route('member_organize')), function($sq) {
                        $sq->where('email_member', request()->phone)->where('id', '!=', $this->route('member_organize'));
                    });
                })
            ],
            'career_main'   => 'required',
            'marketing_main'    => 'required',
            'shop'          => 'required',
            'total_staff'   => 'required',
            'activity.0'    =>  'required',
            'purpose.nhu_cau.0'   => 'required',
            'purpose.kha_nang.0' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name_vietnam.required'         => 'Tên tiếng Việt không được bỏ trống',
            'name_english.required'         => 'Tên tiếng Anh không được bỏ trống',
            'name_sub.required'         => 'Tên viết tắt không được bỏ trống',
            'num_business.required'         => 'Quyết định thành lập/Giấy chứng nhận đăng ký doanh nghiệp số không được bỏ trống',
            'issued_by.required'    => 'Nơi cấp không được bỏ trống',
            'date_at.required'    => 'Ngày cấp thay đổi không được bỏ trống',
            'date_at.tomorrow'    => 'Ngày cấp thay đổi không được lớn hơn ngày mai',
            'date_start_at.required'    => 'Ngày cấp lần đầu không được bỏ trống',
            'date_start_at.tomorrow'    => 'Ngày cấp lần đầu không được lớn hơn ngày mai',
            'type_business.required'    => 'Loại hình doanh nghiệp khong được bỏ trống',
            'pernament_main.required'    => 'Vui lòng chọn tỉnh/thành phố',
            'district_main.required'     => 'Vui lòng chọn quận/huyện',
            'address_main.required'       => 'Vui lòng nhập địa chỉ',
            'pernament_sub.required'   => 'Vui lòng chọn tỉnh/thành phố',
            'district_sub.required'    => 'Vui lòng chọn quận/huyện',
            'address_sub.required'      => 'Vui lòng nhập địa chỉ',
            'phone.required'        => 'Số điện thoại không được bỏ trống',
            'phone.numeric'        => 'Số điện thoại phải là dạng số',
            'phone.unique'        => 'Số điện thoại đã đăng ký',
            'link_web.required'  => 'Link trang web không được bỏ trống',
            'fanpage.required'   => 'Link fanpage không được bỏ trống',
            'representative.required'  => 'Người đại diện không được bỏ trống',
            'position.required'     => 'Chức vụ không được bỏ trống',
            'name_member.required'     => 'Tên người đại diện không được bỏ trống',
            'position_member.required'     => 'Chức vụ người đại diện không được bỏ trống',
            'phone_member.required'     => 'Số điện thoại người đại diện không được bỏ trống',
            'phone_member.numeric'     => 'Số điện thoại người đại diện phải là dạng số',
            'phone_member.unique'     => 'Email người đại diện đã đăng ký',
            'email_member.required'     => 'Email người đại diện không được bỏ trống',
            'email_member.numeric'     => 'Email người đại diện phải là dạng số',
            'email_member.unique'     => 'Số điện thoại người đại diện đã đăng ký',
            'career_main.required'             => 'Các ngành nghề kinh doanh chính không được bỏ trống',
            'marketing_main.required'   =>'Vui lòng chọn tỉnh/thành phố',
            'shop.required'             => 'Chi nhánh, văn phòng tại các tỉnh không được bỏ trống',
            'total_staff.required'      => 'Tổng số CBNV không được bỏ trống',
            'activity.0.required'              => 'Vui lòng chọn một nội dung hoạt động hoặc ghi vào ô khác',
            'purpose.nhu_cau.0.required'                 => 'Vui lòng chọn ít nhất một nhu cầu',
            'purpose.kha_nang.0.required'                 => 'Vui lòng chọn ít nhất một khả năng hoặc ghi vào ô khác',
//            'other.required'      => 'Chọn ít nhất một mục đích hoặc nhập mục đích vào ô khác để đăng ký',
        ];
    }
}
