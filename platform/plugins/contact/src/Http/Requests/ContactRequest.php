<?php

namespace Platform\Contact\Http\Requests;

use Platform\Support\Http\Requests\Request;

class ContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function rules()
    {
        if (setting('enable_captcha') && is_plugin_active('captcha')) {
            return [
                'name'                 => 'required',
                'email'                => 'required|email',
                'content'              => 'required',
                'phone'                => 'required|numeric',
                'g-recaptcha-response' => 'required|captcha',
            ];
        }
        return [
            'name'    => 'required',
            'email'   => 'required|email',
            'content' => 'required',
            'phone'   => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => __("Tên là bắt buộc"),
            'email.email'      => __("Vui lòng nhập đúng định dạng email"),
            'phone.numeric'   => __("Số điện thoại phải là số"),
            'content.required' => trans('plugins/contact::contact.form.content.required'),
        ];
    }
}
