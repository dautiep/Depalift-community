<?php

namespace Platform\PostEvents\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PostEventsRequest extends Request
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
            'category_events' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'Tên bài viết không được để trống',
            'category_events.required'      => 'Vui lòng chọn chuyên mục',
        ];
    }
}
