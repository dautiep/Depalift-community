<?php

return [
    [
        'name' => 'Category trainings',
        'flag' => 'category-training.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'category-training.create',
        'parent_flag' => 'category-training.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'category-training.edit',
        'parent_flag' => 'category-training.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'category-training.destroy',
        'parent_flag' => 'category-training.index',
    ],
];
