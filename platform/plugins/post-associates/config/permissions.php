<?php

return [
    [
        'name' => 'Post associates',
        'flag' => 'post-associates.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'post-associates.create',
        'parent_flag' => 'post-associates.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'post-associates.edit',
        'parent_flag' => 'post-associates.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'post-associates.destroy',
        'parent_flag' => 'post-associates.index',
    ],
];
