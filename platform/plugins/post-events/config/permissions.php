<?php

return [
    [
        'name' => 'Post events',
        'flag' => 'post-events.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'post-events.create',
        'parent_flag' => 'post-events.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'post-events.edit',
        'parent_flag' => 'post-events.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'post-events.destroy',
        'parent_flag' => 'post-events.index',
    ],
];
