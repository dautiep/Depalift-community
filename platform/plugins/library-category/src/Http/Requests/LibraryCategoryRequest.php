<?php

namespace Platform\LibraryCategory\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class LibraryCategoryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:app_library_categories,name',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
        if (request()->route('library_category')) {
            $id = request()->route('library_category');
            $rules = [
                'name' => 'required|unique:app_library_categories,name, '.$id,
                'status' => Rule::in(BaseStatusEnum::values()),
            ];
        }
        return $rules;
    }

    public function messages()
	{
		return [
            'name.required' => 'Tên danh mục không được bỏ trống', 
            'name.unique' => 'Tên danh mục đã được sử dụng',
		];
	}
}
