<?php

namespace Platform\PostEvents\Services;

use Platform\PostEvents\Models\PostEvents;

use Illuminate\Http\Request;

class StoreCategoryService
{

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed|void
     */
    public function execute(Request $request, PostEvents $postEvents)
    {
        $categories = $request->input('category_events');
        
        if (!empty($categories)) {
            $postEvents->categories_events()->detach();
            foreach ($categories as $category) {
                $postEvents->categories_events()->attach($category);
            }
        }
    }
}
