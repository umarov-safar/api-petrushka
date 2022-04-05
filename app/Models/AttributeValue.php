<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attribute_id',
        'value',
        'position',
        'partner_id'
    ];


    const IS_GLOBAL_YES = 1;
    const IS_GLOBAL_NO = 0;

    const DEFAULT_POSITION = 0;

}
