<?php

namespace App\JsonApi\Proxies;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PartnerCustomer
 *
 * Прокси-модель "Партнер"
 * Используется для работы с моделью Partner партнером.
 *
 * @property int $id
 * @property string $name
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

class PartnerCustomer extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * PartnerCustomer constructor.
     *
     * @param Partner|null $partner
     */
    public function __construct(Partner $partner = null)
    {
        $partner = ($partner ? $partner : new Partner());
        //self::bootModel($partner);
        parent::__construct($partner ?: new Partner());
    }
}
