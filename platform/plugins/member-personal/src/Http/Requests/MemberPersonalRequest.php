<?php

namespace Platform\MemberPersonal\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MemberPersonalRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name'              => 'required',
            'birth_day'         => 'required|before:tomorrow',
            'place_birth'       => 'required',
            'country'           => 'required',
            'religion'          => 'required',
            'identify'           => 'required',
            'date_range'        => 'required',
            'issued_by'         => 'required',
            'pernament_main'         => 'required',
            'district_main'          => 'required',
            'address_main'            => 'required',
            'pernament_sub'        => 'required',
            'district_sub'         => 'required',
            'address_sub'           => 'required',
            'mail'              => 'required|email|unique:app_member_personals,mail',
            'num_phone'         => 'required|numericunique:app_member_personals,num_phone',
            'education'         => 'required',
            'works'             => 'required',
            'work_place'        => 'required',
            'position'          => 'required',
            'address_work'           => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
        if((request()->route('member_personal'))){
            $id = request()->route('member_personal');
            $rules = [
                'name'              => 'required',
                'birth_day'         => 'required|before:tomorrow',
                'place_birth'       => 'required',
                'country'           => 'required',
                'religion'          => 'required',
                'identify'           => 'required',
                'date_range'        => 'required',
                'issued_by'         => 'required',
                'pernament_main'         => 'required',
                'district_main'          => 'required',
                'address_main'            => 'required',
                'pernament_sub'        => 'required',
                'district_sub'         => 'required',
                'address_sub'           => 'required',
                'mail'              => 'required|email|unique:app_member_personals,mail, '.$id,
                'num_phone'         => 'required|numeric|unique:app_member_personals,num_phone, '.$id,
                'education'         => 'required',
                'works'             => 'required',
                'work_place'        => 'required',
                'position'          => 'required',
                'purposes.0'        => 'required',
                'address_work'           => 'required',
                'status' => Rule::in(BaseStatusEnum::values()),
            ];
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'         => 'Họ và tên không được bỏ trống',
            'birth_day.required'    => 'Ngày sinh không được bỏ trống',
            'birth_day.before'      => 'Ngày sinh không được lớn hơn ngày hiện tại',
            'place_birth.required'  => 'Nơi sinh không được bỏ trống',
            'country.required'      => 'Quốc tịch không được bỏ trống',
            'religion.required'     => 'Tôn giáo không được bỏ trống',
            'identify.required'      => 'CMND không được bỏ trống',
            'date_range.required'   => 'Ngày cấp không được bỏ trống',
            'issued_by.required'    => 'Nơi cấp không được bỏ trống',
            'pernament_main.required'    => 'Vui lòng chọn tỉnh/thành phố',
            'district_main.required'     => 'Vui lòng chọn quận/huyện',
            'address_main.required'       => 'Vui lòng nhập địa chỉ',
            'pernament_sub.required'   => 'Vui lòng chọn tỉnh/thành phố',
            'district_sub.required'    => 'Vui lòng chọn quận/huyện',
            'address_sub.required'      => 'Vui lòng nhập địa chỉ',
            'mail.required'        => 'Email không được bỏ trống',
            'mail.email'           => 'Email sai định dạng',
            'mail.unique'          => 'Email đã được sử dụng',
            'num_phone.required'    => 'Số điện thoại không được bỏ trống',
            'num_phone.numeric'     => 'Số điện thoại phải ở dạng số',
            'education.required'    => 'Học vấn chuyên môn không được bỏ trống',
            'works.required'        => 'Số năm làm việc không được bỏ trống',
            'work_place.required'   => 'Nơi công tác không được bỏ trống',
            'position.required'     => 'Chức vụ không được bỏ trống',
            'purposes.0.required'      => 'Vui lòng chọn một mục đích tham gia hoặc nhập vào ô khác',
            'address_work.required'      => 'Địa chỉ làm việc không được bỏ trống',
//            'other.required'      => 'Chọn ít nhất một mục đích hoặc nhập mục đích vào ô khác để đăng ký',
        ];
    }
}
