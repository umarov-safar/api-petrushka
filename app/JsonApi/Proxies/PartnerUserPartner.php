<?php

namespace App\JsonApi\Proxies;

use App\Models\PartnerUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PartnerUserPartner
 *
 * Прокси-модель "Сотрудник партнера"
 * Используется для работы с моделья PartnerUser партнером.
 *
 * @property int $id
 * @property int $user_id
 * @property int $partner_id
 * @property string $phone
 * @property bool $status
 * @property bool $is_admin
 * @property string $setting_info
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 * @method static Builder find($value)
 *
 * @package App/JsonApi/Proxies
 */

class PartnerUserPartner extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyPartner constructor.
     *
     * @param PartnerUser|null $partnerUser
     */
    public function __construct(PartnerUser $partnerUser = null)
    {
        //\Log::debug('_construct');
        $partnerUser = ($partnerUser ? $partnerUser : new PartnerUser());
        self::bootModel($partnerUser);

        parent::__construct($partnerUser ?: new PartnerUser());
    }

    /**
     * Установка глобальной выборки для модели "сотрудники партнера"
     * Это нужно для того чтобы партнёру(админу) отобразить только его сотрудников.
     *
     * @param PartnerUser &$partnerUser
     * @return void
     */
    protected static function bootModel(PartnerUser &$partnerUser)
    {
        //\Log::debug('boot');
        //parent::boot();

        // never let a company user see the users of other companies
        $user = Auth::user();
        //\Log::debug('$user');
        if (Auth::check() && Bouncer::is($user)->a('partner')) {
            //\Log::debug($user->partner->id);
            //$partners = $user->partners()->where('admin_user_id', $user->id)->get();
            $partners = $user->partners()->forAdminUser($user->id)->get();
            if($partners){
                $partnersIds = $partners->pluck('id')->all() ?? [];
                $partnerUser::addGlobalScope('partner_id', function (Builder $builder) use ($partnersIds) {
                    $builder->whereIn('partner_id', $partnersIds);
                });
            }
        }
    }

}
