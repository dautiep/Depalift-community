<?php

return [
    [
        'name' => 'Category events',
        'flag' => 'category-events.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'category-events.create',
        'parent_flag' => 'category-events.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'category-events.edit',
        'parent_flag' => 'category-events.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'category-events.destroy',
        'parent_flag' => 'category-events.index',
    ],
];
