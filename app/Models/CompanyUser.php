<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CompanyUser
 *
 * Модель "Сотрудник компании"
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
 * @package App/Models
 */
class CompanyUser extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_user';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = ['user_id', 'company_id', 'setting_info', 'phone', 'status', 'is_admin'];

    protected $casts = [
        'setting_info' => 'array'
    ];

    const IS_ADMIN_YES = 1; //
    const IS_ADMIN_NO = 0; //

    const BLOCK_YES = 1; // Заблокирован
    const BLOCK_NO = 0; // Не заблокирован


    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
