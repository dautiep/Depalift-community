<?php

namespace Platform\MemberPersonal\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;

class MemberPersonal extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_member_personals';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'sex',
        'birth_day',
        'place_birth',
        'country',
        'religion',
        'identify',
        'date_range',
        'issued_by',
        'pernament_main',
        'district_main',
        'address_main',
        'pernament_sub',
        'district_sub',
        'address_sub',
        'mail',
        'num_phone',
        'link_fb',
        'education',
        'works',
        'work_place',
        'position',
        'address_work',
        'degree',
        'capacity',
        'file',
        'purpose',
        'assure',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}