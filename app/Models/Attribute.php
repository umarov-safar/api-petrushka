<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'slug',
        'position',
        'partner_id'
    ];

    const TYPE_TEXT = 1;
    const TYPE_NUMBER = 2;
    const TYPE_SELECT = 3;

    // It will be used in request validation and in the frontend
    const ATTRIBUTE_TYPES = [
      self::TYPE_TEXT,
      self::TYPE_NUMBER,
      self::TYPE_SELECT
    ];


    const IS_GLOBAL_NO = 0;
    const IS_GLOBAL_YES = 1;

    const DEFAULT_POSITION = 0;


    // Attribute values of attribute with type select
    public function values() : HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
