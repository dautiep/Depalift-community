<?php

namespace Platform\Blog\Http\Requests;

use Platform\Base\Enums\BaseStatusEnum;
use Platform\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CategoryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [ 
            'name'        => 'required|max:120',
            'description' => 'max:400',
            'order'       => 'required|integer|min:0|max:127',
            'status'      => Rule::in(BaseStatusEnum::values()),
        ];

        if (request()->route('category')) {
            $id = request()->route('category');
            $rules = [
                'name'        => 'required|max:120|unique:categories,name, '.$id,
                'description' => 'max:400',
                'order'       => 'required|integer|min:0|max:127',
                'status'      => Rule::in(BaseStatusEnum::values()),
            ];
        }
        return $rules;
    }
}
