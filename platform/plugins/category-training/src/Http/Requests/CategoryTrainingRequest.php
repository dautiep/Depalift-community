<?php

namespace Platform\CategoryTraining\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CategoryTrainingRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:app_category_training,name',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
        if (request()->route('category_training')) {
            $id = request()->route('category_training');
            $rules = [
                'name' => 'required|unique:app_category_training,name, '.$id,
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
