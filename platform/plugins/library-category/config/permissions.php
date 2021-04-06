<?php

return [
    [
        'name' => 'Library categories',
        'flag' => 'library-category.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'library-category.create',
        'parent_flag' => 'library-category.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'library-category.edit',
        'parent_flag' => 'library-category.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'library-category.destroy',
        'parent_flag' => 'library-category.index',
    ],
];
