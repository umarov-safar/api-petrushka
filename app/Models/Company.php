<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = ['inn', 'info', 'is_block', 'admin_user_id'];

    protected $casts = [
        'info' => 'array',
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

    public function companyUsers()
    {
        //return $this->belongsToMany(User::class, 'company_user')->withPivot('phone', 'setting_info', 'status');
        return $this->hasMany(CompanyUser::class);
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
     * Заготовка запроса на получение списка компаний через таблицу сотрудников для определенного пользователя
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConcreteCompanyUser($query, $userId)
    {
        return $query->whereHas('companyUsers', function ($query) use ($userId) {
            $query->where('company_user.user_id', $userId);
        });
    }

    /**
     * Заготовка запроса на получение списка компаний, в которых указан конкретный админ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAdminUser($query, $userId)
    {
        return $query->where('companies.admin_user_id', $userId);
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
