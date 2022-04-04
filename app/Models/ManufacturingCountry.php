<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ManufacturingCountry
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManufacturingCountry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ManufacturingCountry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

}
