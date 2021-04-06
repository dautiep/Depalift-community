<?php

namespace Platform\PostTraining\Services;

use Platform\PostTraining\Models\PostTraining;

use Illuminate\Http\Request;

class StoreCategoryTrainingService
{

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed|void
     */
    public function execute(Request $request, PostTraining $postTraining)
    {
        $categories = $request->input('category_training');
        
        if (!empty($categories)) {
            $postTraining->categories_training()->detach();
            foreach ($categories as $category) {
                $postTraining->categories_training()->attach($category);
            }
        }
    }
}
