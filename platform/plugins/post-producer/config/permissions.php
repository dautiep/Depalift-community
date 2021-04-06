<?php

return [
    [
        'name' => 'Post producers',
        'flag' => 'post-producer.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'post-producer.create',
        'parent_flag' => 'post-producer.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'post-producer.edit',
        'parent_flag' => 'post-producer.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'post-producer.destroy',
        'parent_flag' => 'post-producer.index',
    ],
];
