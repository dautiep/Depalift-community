<?php

return [
    [
        'name' => 'Post trainings',
        'flag' => 'post-training.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'post-training.create',
        'parent_flag' => 'post-training.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'post-training.edit',
        'parent_flag' => 'post-training.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'post-training.destroy',
        'parent_flag' => 'post-training.index',
    ],
];
