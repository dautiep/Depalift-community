<?php

namespace Platform\CategoryEvents\Services;

use Platform\PostEvents\Models\PostEvents;
use Platform\CategoryEvents\Services\Abstracts\CategoryEventsAbstract;
use Illuminate\Http\Request;

class CategoryEventsService extends CategoryEventsAbstract
{

    /**
     * @param Request $request
     * @param PostEvents $postEvents
     * @return mixed|void
     */
    public function execute(Request $request, PostEvents $postEvents)
    {
        $categoryevents = $request->input('app_category_events');
        if (!empty($categoryevents)) {
            $postEvents->category_events()->detach();
            foreach ($categoryevents as $category) {
                $postEvents->category_events()->attach($category);
            }
        }
    }
}