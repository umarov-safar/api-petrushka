<?php

namespace App\JsonApi\Proxies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MyCompanyCustomer
 *
 * Прокси-модель "Партнер"
 * Используется для работы с моделью Partner партнером.
 *
 * @property int $id
 * @property string $inn
 * @property string $info
 * @property string $phone
 * @property int $admin_user_id
 * @property bool $is_block
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 * @method static Builder find($value)
 *
 * @package App/JsonApi/Proxies
 */

class MyCompanyCustomer extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyPartner constructor.
     *
     * @param Company|null $company
     */
    public function __construct(Company $company = null)
    {
        $company = ($company ? $company : new Company());
        self::bootModel($company);
        parent::__construct($company ?: new Company());
    }

    /**
     * Установка глобальной выборки для модели "партнёр"
     * Это нужно для того чтобы партнёру(админу) отобразить только его объекты Партнёр.
     *
     * @param Company &$company
     * @return void
     */
    protected static function bootModel(Company &$company)
    {
        $user = Auth::user();
        //var_dump($user);
        //exit;

        $company::addGlobalScope('myCompanies', function (Builder $builder) use ($user) {
            $builder->concreteCompanyUser($user->id);
        });
    }

}
