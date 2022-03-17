<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Silber\Bouncer\Database\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const ROLE_SUPERADMIN = 1; // суперадмин
    const ROLE_ADMIN = 2; // админ
    const ROLE_CUSTOMER = 3; // покупатель
    const ROLE_PARTNER = 4; // партнер
    const ROLE_PARTNER_ADMIN = 5; // партнер админ
    const ROLE_PARTNER_EMPLOYEE = 6; // партнер сотрудник
    const ROLE_CUSTOMER_ADMIN = 7; // покупатель админ
    const ROLE_CUSTOMER_EMPLOYEE = 8; // покупатель сотрудник

    const ALLOW_MANUALLY_SET_ROLES = [
        self:: ROLE_SUPERADMIN,
        self:: ROLE_ADMIN,
        self:: ROLE_CUSTOMER,
        self:: ROLE_PARTNER,
    ];

    const ALLOW_MANUALLY_TURN_OFF_ROLES = [
        self:: ROLE_SUPERADMIN,
        self:: ROLE_ADMIN,
    ];

    const DISALLOW_MANUALLY_TURN_OFF_ROLES = [
        self:: ROLE_CUSTOMER,
        self:: ROLE_PARTNER,
    ];

    const DISALLOW_MANUALLY_SET_ROLES = [
        self::ROLE_PARTNER_ADMIN,
        self::ROLE_PARTNER_EMPLOYEE,
        self::ROLE_CUSTOMER_ADMIN,
        self::ROLE_CUSTOMER_EMPLOYEE,
    ];



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeAllowManuallySet($query, bool $allow)
    {
        if($allow)
        {
            // получить список ролей, которые можно устанавливать вручную из админом
            return $query->whereIn('id', self::ALLOW_MANUALLY_SET_ROLES);
        }
        else
        {
            // получить список ролей, которые нельзя устанавливать вручную из админом
            return $query->whereNotIn('id', self::ALLOW_MANUALLY_SET_ROLES);
        }

    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
