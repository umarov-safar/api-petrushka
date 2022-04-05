<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name Название продукта
 * @property int $sku Артикуль
 * @property string $description Кароткое описание
 * @property string $description_original Длиное описание
 * @property string $slug Ссылка - слаг
 * @property string $human_volume Кг, Шт, Метр и тд
 * @property string|null $canonical_permalink Линк
 * @property int $is_alcohol
 * @property int $category_id
 * @property int|null $brand_id
 * @property int|null $manufacturer_id
 * @property int|null $manufacturing_country_id
 * @property int $partner_id
 * @property string|null $attributes Атрибуты на товар
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCanonicalPermalink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescriptionOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHumanVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsAlcohol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereManufacturingCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name',
      'sku',
      'description',
      'description_original',
      'slug',
      'human_volume',
      'canonical_permalink',
      'is_alcohol',
      'brand_id',
      'category_id',
      'manufacturer_id',
      'manufacturing_country_id',
      'partner_id',
      'attributes'
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    const IS_ALCOHOL_YES = 1;
    const IS_ALCOHOL_NO = 0;

}
