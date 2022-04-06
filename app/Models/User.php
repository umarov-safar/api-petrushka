<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * Class User
 *
 * модель "Пользователь"
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $code
 * @property bool $is_block
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 * @method static Builder find($value)
 *
 * @package App/Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndAbilities, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d',
    ];

    const BLOCK_YES = 1; // Заблокирован
    const BLOCK_NO = 0; // Не заблокирован



    //--------------------      Relationships     -----------------------//

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partnerOwner() : HasOne
    {
        return $this->hasOne(Partner::class, 'admin_user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partners() : BelongsToMany
    {
        /*return $this->belongsToMany(Partner::class)
            ->using(PartnerUser::class)
            ->withPivot('status', 'setting_info', 'is_admin');*/
        return $this->belongsToMany(Partner::class)
            ->using(PartnerUser::class);
    }


    /**
     * @url https://stackoverflow.com/a/66969048/12562591
     * @return \Illuminate\Database\Eloquent\Relations\hasOneThrough
     */
    /*
    public function partner() : hasOneThrough
    {
        //return $this->hasOne(PartnerUser::class)->ofMany();
        return $this->hasOneThrough(Partner::class, PartnerUser::class, 'user_id', 'id', 'id', 'partner_id')
            ->where('status', false); // не заблокированный сотрудник
    }
    */

    // company через company_user где status=0 (не заблокирован)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies() : BelongsToMany
    {
        return $this->belongsToMany(Company::class)
            ->using(CompanyUser::class)
            ->withPivot('status', 'setting_info', 'is_admin');
    }

    /**
     * @url https://stackoverflow.com/a/66969048/12562591
     * @return \Illuminate\Database\Eloquent\Relations\hasOneThrough
     */
    /*
    public function company() : hasOneThrough
    {
        //return $this->hasOne(PartnerUser::class)->ofMany();
        return $this->hasOneThrough(Company::class, CompanyUser::class, 'user_id', 'id', 'id', 'company_id')
            ->where('status', false); // не заблокированный сотрудник
    }*/

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleId
     * @note https://github.com/JosephSilber/bouncer/issues/126#issuecomment-246983616
     */
    public function scopeWhereCanRole($query, $roleId)
    {
        $query->whereHas('roles', function ($query) use ($roleId) {
            $query->where('roles.id', $roleId);
        });
    }

}
