<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['name', 'phone', 'info', 'is_block', 'admin_user_id'];

    protected $casts = [
        'info' => 'array'
    ];

    const BLOCK_YES = 1; // Заблокирован
    const BLOCK_NO = 0; // Не заблокирован


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

    public function partnerUsers1()
    {
        return $this->belongsToMany(User::class, 'partner_user')->withPivot('phone', 'setting_info', 'status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees() : BelongsToMany
    {
        /*return $this->belongsToMany(Partner::class)
            ->using(PartnerUser::class)
            ->withPivot('status', 'setting_info', 'is_admin');*/
        return $this->belongsToMany(User::class)
            ->using(PartnerUser::class)
            ->withPivot('status', 'setting_info', 'is_admin');;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partnerUsers() : hasMany
    {
        /*return $this->belongsToMany(Partner::class)
            ->using(PartnerUser::class)
            ->withPivot('status', 'setting_info', 'is_admin');*/
        return $this->hasMany(PartnerUser::class);
        //    ->withPivot('status', 'setting_info', 'is_admin');
        //return $this->hasMany(PartnerUser::class);
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Заготовка запроса на получение списка партнеров через таблицу сотрудников для определенного пользователя
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConcretePartnerUser($query, $userId)
    {
        return $query->whereHas('partnerUsers', function ($query) use ($userId) {
            $query->where('partner_user.user_id', $userId);
        });
    }

    /**
     * Заготовка запроса на получение списка партнеров, в которых указан конкретный админ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAdminUser($query, $userId)
    {
        return $query->where('partners.admin_user_id', $userId);
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
