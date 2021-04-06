<?php

return [
    [
        'name' => 'Category associates',
        'flag' => 'category-associates.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'category-associates.create',
        'parent_flag' => 'category-associates.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'category-associates.edit',
        'parent_flag' => 'category-associates.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'category-associates.destroy',
        'parent_flag' => 'category-associates.index',
    ],
];
