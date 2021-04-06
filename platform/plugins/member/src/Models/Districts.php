<?php

namespace Platform\Member\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin \Eloquent
 */
class Districts extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'type',
        'province_id',
    ];





}
