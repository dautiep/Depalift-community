<?php

return [
    [
        'name' => 'Library documents',
        'flag' => 'library-document.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'library-document.create',
        'parent_flag' => 'library-document.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'library-document.edit',
        'parent_flag' => 'library-document.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'library-document.destroy',
        'parent_flag' => 'library-document.index',
    ],
];
