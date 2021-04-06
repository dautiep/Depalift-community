<?php

namespace Platform\PostTraining\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PostTrainingRequest extends Request
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
            'category_training'  => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required'                     => 'Tên bài viết không được bỏ trống',
            'category_training.required'        => 'Vui lòng chọn loại danh mục',
        ];
    }
}
