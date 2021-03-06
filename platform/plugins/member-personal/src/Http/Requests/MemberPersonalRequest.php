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
            'name.required'         => 'Ho?? va?? t??n kh??ng ????????c bo?? tr????ng',
            'birth_day.required'    => 'Nga??y sinh kh??ng ????????c bo?? tr????ng',
            'birth_day.before'      => 'Nga??y sinh kh??ng ????????c l????n h??n nga??y hi????n ta??i',
            'place_birth.required'  => 'N??i sinh kh??ng ????????c bo?? tr????ng',
            'country.required'      => 'Qu????c ti??ch kh??ng ????????c bo?? tr????ng',
            'religion.required'     => 'T??n gia??o kh??ng ????????c bo?? tr????ng',
            'identify.required'      => 'CMND kh??ng ????????c bo?? tr????ng',
            'date_range.required'   => 'Nga??y c????p kh??ng ????????c bo?? tr????ng',
            'issued_by.required'    => 'N??i c????p kh??ng ????????c bo?? tr????ng',
            'pernament_main.required'    => 'Vui lo??ng cho??n ti??nh/tha??nh ph????',
            'district_main.required'     => 'Vui lo??ng cho??n qu????n/huy????n',
            'address_main.required'       => 'Vui lo??ng nh????p ??i??a chi??',
            'pernament_sub.required'   => 'Vui lo??ng cho??n ti??nh/tha??nh ph????',
            'district_sub.required'    => 'Vui lo??ng cho??n qu????n/huy????n',
            'address_sub.required'      => 'Vui lo??ng nh????p ??i??a chi??',
            'mail.required'        => 'Email kh??ng ????????c bo?? tr????ng',
            'mail.email'           => 'Email sai ??i??nh da??ng',
            'mail.unique'          => 'Email ??a?? ????????c s???? du??ng',
            'num_phone.required'    => 'S???? ??i????n thoa??i kh??ng ????????c bo?? tr????ng',
            'num_phone.numeric'     => 'S???? ??i????n thoa??i pha??i ???? da??ng s????',
            'education.required'    => 'Ho??c v????n chuy??n m??n kh??ng ????????c bo?? tr????ng',
            'works.required'        => 'S???? n??m la??m vi????c kh??ng ????????c bo?? tr????ng',
            'work_place.required'   => 'N??i c??ng ta??c kh??ng ????????c bo?? tr????ng',
            'position.required'     => 'Ch????c vu?? kh??ng ????????c bo?? tr????ng',
            'purposes.0.required'      => 'Vui l??ng ch???n m???t m???c ????ch tham gia ho???c nh???p v??o ?? kh??c',
            'address_work.required'      => '??i??a chi?? la??m vi????c kh??ng ????????c bo?? tr????ng',
//            'other.required'      => 'Cho??n i??t nh????t m????t mu??c ??i??ch ho????c nh????p mu??c ??i??ch va??o ?? kha??c ?????? ????ng ky??',
        ];
    }
}
