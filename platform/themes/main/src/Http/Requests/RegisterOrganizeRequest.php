<?php

namespace Theme\Main\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RegisterOrganizeRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name_vietnam'              => 'required',
            'name_english'              => 'required',
            'name_sub'                  => 'required',
            'num_business'              => 'required',
            'issued_by'                 => 'required',
            'date_start_at'             => 'required|before:tomorrow',
            'date_at'                   => 'required|before:tomorrow',
            'type_business'             => 'required',
            'pernament_main'             => 'required',
            'district_main'             => 'required',
            'address_main'             => 'required',
            'pernament_sub'             => 'required',
            'district_sub'             => 'required',
            'address_sub'             => 'required',
            'phone'                    => 'required|numeric|unique:app_member_organizes,phone',
            'email'                    => 'required|email|unique:app_member_organizes,email',
            'link_web'                    => 'required',
            'fanpage'                     => 'required',
            'representative'                    => 'required',
            'position'                    => 'required',
            'name_member'                 => 'required',
            'position_member'             => 'required',
            'email_member'                => 'required|email|unique:app_member_organizes,email',
            'phone_member'                => 'required|numeric|unique:app_member_organizes,phone_member',
            'career_main'                    => 'required',
            'marketing_main'              => 'required',
            'shop'                        => 'required',
            'total_staff'                 => 'required',
            'activity.0'                  => 'required',
            'purpose.nhu_cau.0'                     => 'required',
            'purpose.kha_nang.0'                     => 'required',
            'file'                  => 'required|max:10|min:10',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
        return $rules;  
    }

    public function messages()
    {
        return [
            'name_vietnam.required'         => 'Tên tiếng Việt không được bỏ trống',
            'name_english.required'         => 'Tên tiếng Anh không được bỏ trống',
            'name_sub.required'         => 'Tên viết tắt không được bỏ trống',
            'num_business.required'         => 'Quyết định thành lập không được bỏ trống',
            'issued_by.required'    => 'Nơi cấp không được bỏ trống',
            'date_start_at.required'    => 'Ngày cấp lần đầu không được bỏ trống',
            'date_start_at.tomorrow'    => 'Ngày cấp lần đầu không được lớn hơn ngày mai',
            'date_at.required'    => 'Ngày cấp không được bỏ trống',
            'date_at.tomorrow'    => 'Ngày cấp không được lớn hơn ngày mai',
            'type_business.required'    => 'Loại hình doanh nghiệp không được bỏ trống',
            'pernament_main.required'    => 'Vui lòng chọn tỉnh/thành phố',
            'district_main.required'     => 'Vui lòng chọn quận/huyện',
            'address_main.required'       => 'Vui lòng nhập địa chỉ',
            'pernament_sub.required'   => 'Vui lòng chọn tỉnh/thành phố',
            'district_sub.required'    => 'Vui lòng chọn quận/huyện',
            'address_sub.required'      => 'Vui lòng nhập địa chỉ',
            'phone.required'        => 'Số điện thoại không được bỏ trống',
            'phone.numeric'        => 'Số điện thoại phải là dạng số',
            'phone.unique'        => 'Số điện thoại đã đăng ký',
            'email.required'        => 'Email không được bỏ trống',
            'email.email'        => 'Email không đúng định dạng',
            'email.unique'        => 'Email đã được đăng ký',
            'fanpage.required'    => 'Fanpage không được bỏ trống',
            'link_web.required'  => 'Link trang web không được bỏ trống',
            'representative.required'  => 'Người đại diện không được bỏ trống',
            'position.required'     => 'Chức vụ không được bỏ trống',
            'name_member.required'     => 'Tên người đại diện không được bỏ trống',
            'position_member.required'     => 'Chức vụ người đại diện không được bỏ trống',
            'email_member.required'        => 'Email của người đại diện không được bỏ trống',
            'email_member.email'        => 'Email của người đại diện không đúng định dạng',
            'email_member.unique'        => 'mail của người đại diện đã được đăng ký',
            'phone_member.required'     => 'Số điện thoại người đại diện không được bỏ trống',
            'phone_member.numeric'     => 'Số điện thoại người đại diện phải là dạng số',
            'phone_member.unique'     => 'Số điện thoại người đại diện đã đăng ký',
            'career_main.required'             => 'Sản phẩm, dịch vụ chính không được bỏ trống',
            'marketing_main.required'           =>'Vui lòng chọn Tỉnh/Thành phố',
            'shop.required'                     => 'Chi nhánh/ văn phòng không được bỏ trống',
            'total_staff.required'              => 'Tổng số CBNV không được bỏ trống',
            'activity.0.required'       => 'Vui lòng chọn một nội dung hoạt động hoặc ghi vào ô khác',
            'purpose.nhu_cau.0.required'                 => 'Vui lòng chọn ít nhất một nhu cầu',
            'purpose.kha_nang.0.required'                 => 'Vui lòng chọn ít nhất một khả năng hoặc ghi vào ô khác',
            'file.required'           => 'Bạn phải tải lên bản cam kết và đơn xin gia nhập Hiệp hội',
            'file.max'           => 'Bạn tải quá số lượng giấy tờ liên quan',
            'file.min'           => 'Bạn phải tải đầy dủ giấy tờ liên quan',
//            'other.required'      => 'Chọn ít nhất một mục đích hoặc nhập mục đích vào ô khác để đăng ký',
        ];
    }

}