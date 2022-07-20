<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name Название категории
 * @property int $type Тип - это верхний уровень или нижний уровень
 * @property string $slug Слаг - Ссылка
 * @property int $position Поле для сортировка
 * @property int $active Категория активная если значения 1 не активная 0
 * @property int|null $parent_id Идентификатор родительского каталога
 * ['id' => int, 'category_name' => string, 'active' => boolean]
 * @property int|null $related_partners Партнёры у каторых отабражает эта категория
 * @property string|null $icon_url Ссылка на иконка
 * @property string|null $alt_icon Описание иконка
 * @property string|null $canonical_url Канонический URL
 * @property int|null $depth Уровень категории
 * @property string|null $children
 * @property string|null $requirements требования категории
 * @property string|null $product_counts Количество продуктов в категории
 * @property string|null $promo_service
 * @property string|null $attributes Атрибут категории
 * @property bool $is_alcohol Является ли категория алкогольная? 1 - да; 0 - нет
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAltIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsAlcohol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereRelatedPartners($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePromoService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 */
class Category extends Model
{
    use HasFactory;
    use HasJsonRelationships;

    protected $fillable = [
        'name',
        'type',
        'slug',
        'position',
        'active',
        'parent_id',
        'related_partners',
        'icon_url',
        'alt_icon',
        'canonical_url',
        'depth',
        'requirements',
        'attributes',
        'is_alcohol'
    ];

    protected $casts = [
        'requirements' => 'array',
        'promo_service' => 'array',
        'attributes' => 'array',
        'related_partners' => 'array',
    ];

    /*
     * DEPARTMENT - верхний уровень
     * TAXON - нижний уровень
     */
    const TYPE_DEPARTMENT = 1;
    const TYPE_TAXON = 2;

    const TYPES  = [
      self::TYPE_DEPARTMENT,
      self::TYPE_TAXON,
    ];

    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;

    const IS_ALCOHOL_YES = 1;
    const IS_ALCOHOL_NO = 0;

    const DEFAULT_POSITION = 0;


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function  partners()
    {
        return $this->belongsToJson(Partner::class, 'related_partners[]->id');
    }

}
