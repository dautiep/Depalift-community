<?php

namespace Platform\PostAssociates\Services;

use Platform\PostAssociates\Models\PostAssociates;

use Illuminate\Http\Request;

class StoreCategoryAssociatesService
{

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed|void
     */
    public function execute(Request $request, PostAssociates $postAssociates)
    {
        $categories = $request->input('category_associates');
        
        if (!empty($categories)) {
            $postAssociates->categories_associates()->detach();
            foreach ($categories as $category) {
                $postAssociates->categories_associates()->attach($category);
            }
        }
    }
}
