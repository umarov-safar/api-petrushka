<?php

namespace App\JsonApi\Proxies;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AccountPartner
 *
 * Прокси-модель "Аккаунт"
 * Используется для работы с моделью User партнером.
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
 * @package App/JsonApi/Proxies
 */

class AccountPartner extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyPartner constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $user = ($user ? $user : new User());
        self::bootModel($user);
        parent::__construct($user ?: new User());
    }

    /**
     * Установка глобальной выборки для модели "Пользователь
     *
     * @param User &$user
     * @return void
     */
    protected static function bootModel(User &$user)
    {
        if($userNow = Auth::user()){
            $user::addGlobalScope('userNow', function (Builder $builder) use ($userNow) {
                $builder->where('id', $userNow->id);
            });
        }
    }

}
