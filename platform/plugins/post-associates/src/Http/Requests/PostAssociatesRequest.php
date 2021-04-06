<?php

namespace Platform\PostAssociates\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PostAssociatesRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'category_associates'   =>  'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Tên hội viên không được để trống',
            'category_associates.required'      => 'Vui lòng chọn chuyên mục',
        ];
    }
}
