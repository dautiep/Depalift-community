<?php

if (!function_exists('get_old_purpose_another')) {
    /**
     * @param int $limit
     * @return Collection
     */
    function get_old_purpose_another($old = [], $purposes = [])
    {
        if(count($old) == 0) {
            return '';
        }

        $purposes = array_map(function($item) {
            return isset($item[0]['value']) ? $item[0]['value'] : '';
        }, $purposes);

        if(count($purposes) == 0) {
            return isset($old[0]) ? $old[0] : '';
        }


        $anotherPurpose = array_filter($old, function($item) use($purposes) {
            return (Bool)!in_array($item, $purposes);
        });


        if(count($anotherPurpose) > 0) {
            return array_values($anotherPurpose)[0];
        }

        return '';
    }
}

if(!function_exists('get_old_activity_another')){
    /**
     * @param int $limit
     * @return Collection
     */

     function get_old_activity_another($old = [], $activities = []){
        if(count($old) == 0){
            return '';
        }

        $activities = array_map(function($item){
            return isset($item[0]['value']) ? $item[0]['value'] : ''; 
        }, $activities);


        if(count($activities) == 0) {
            return isset($old[0]) ? $old[0] : '';
        }

        $anotherActivity = array_filter($old, function($item) use($activities) {
            return (Bool)!in_array($item, $activities);
        });

        if(count($anotherActivity) > 0) {
            return array_values($anotherActivity)[0];
        }

        return '';

    }
}   