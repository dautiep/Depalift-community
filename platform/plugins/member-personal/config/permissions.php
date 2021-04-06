<?php

return [
    [
        'name' => 'Member personals',
        'flag' => 'member-personal.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'member-personal.create',
        'parent_flag' => 'member-personal.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'member-personal.edit',
        'parent_flag' => 'member-personal.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'member-personal.destroy',
        'parent_flag' => 'member-personal.index',
    ],
];
