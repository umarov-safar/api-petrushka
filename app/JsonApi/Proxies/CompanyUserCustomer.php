<?php

namespace App\JsonApi\Proxies;

use App\Models\CompanyUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CompanyUserCustomer
 *
 * Прокси-модель "Сотрудник компании"
 * Используется для работы с моделью CompanyUser покупателем.
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
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

class CompanyUserCustomer extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyUserCustomer constructor.
     *
     * @param CompanyUser|null $companyUser
     */
    public function __construct(CompanyUser $companyUser = null)
    {
        //\Log::debug('_construct');
        $companyUser = ($companyUser ? $companyUser : new CompanyUser());
        self::bootModel($companyUser);

        parent::__construct($companyUser ?: new CompanyUser());
    }

    /**
     * Установка глобальной выборки для модели "сотрудники партнера"
     * Это нужно для того чтобы партнёру(админу) отобразить только его сотрудников.
     *
     * @param CompanyUser &$companyUser
     * @return void
     */
    protected static function bootModel(CompanyUser &$companyUser)
    {
        //\Log::debug('boot');
        //parent::boot();

        // never let a company user see the users of other companies
        $user = Auth::user();
        //\Log::debug('$user');
        if (Auth::check() && Bouncer::is($user)->a('customer')) {
            //\Log::debug($user->partner->id);
            //$partners = $user->partners()->where('admin_user_id', $user->id)->get();
            $companies = $user->companies()->forAdminUser($user->id)->get();
            if($companies){
                $companiesIds = $companies->pluck('id')->all() ?? [];
                $companyUser::addGlobalScope('company_id', function (Builder $builder) use ($companiesIds) {
                    $builder->whereIn('company_id', $companiesIds);
                });
            }
        }
    }

}
