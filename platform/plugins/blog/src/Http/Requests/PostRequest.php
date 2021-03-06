<?php

namespace Platform\Blog\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Blog\Supports\PostFormat;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PostRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'categories'  => 'required',
            'format_type' => Rule::in(array_keys(PostFormat::getPostFormats(true))),
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Tên bài viết không được để trống',
            'categories.required'   =>  'Vui lòng chọn chuyên mục',
        ];
    }
}
