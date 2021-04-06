<?php

namespace Platform\Member\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin \Eloquent
 */
class Provinces extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'type',
    ];





}
