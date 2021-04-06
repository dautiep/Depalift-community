<?php

namespace Platform\LibraryDocument\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class LibraryDocumentRequest extends Request
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
            'library_category_id' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    public function messages()
    {
        return [
            'name.required'                     => 'Tên tài liệu không được bỏ trống',
            'library_category_id.required'      => 'Vui lòng chọn loại tài liệu',
        ];
    }
}
