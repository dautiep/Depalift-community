<?php

namespace Platform\MemberOrganize\Models;

use Platform\Base\Traits\EnumCastable;
use Platform\Base\Enums\BaseStatusEnum;
use Platform\Base\Models\BaseModel;

class MemberOrganize extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_member_organizes';

    /**
     * @var array
     */
    protected $fillable = [
        'name_vietnam',
        'name_english',
        'name_sub',
        'num_business',
        'issued_by',
        'date_start_at',
        'date_at',
        'type_business',
        'pernament_main',
        'district_main',
        'address_main',
        'pernament_sub',
        'district_sub',
        'address_sub',
        'phone',
        'email',
        'link_web',
        'fanpage',
        'representative',
        'position',
        'name_member',
        'position_member',
        'phone_member',
        'email_member',
        'career_main',
        'logo_main',
        'marketing_main',
        'shop',
        'total_staff',
        'total_staff_tech',
        'activity',
        'activity_for_latest_years',
        'purpose',
        'file',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
