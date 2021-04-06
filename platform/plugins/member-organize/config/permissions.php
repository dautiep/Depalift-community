<?php

return [
    [
        'name' => 'Member organizes',
        'flag' => 'member-organize.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'member-organize.create',
        'parent_flag' => 'member-organize.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'member-organize.edit',
        'parent_flag' => 'member-organize.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'member-organize.destroy',
        'parent_flag' => 'member-organize.index',
    ],
];
