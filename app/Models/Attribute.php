<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'slug',
        'position',
        'partner_id'
    ];

    // Types of attributes
    const TYPES_OF_ATTRIBUTES = [
      'string' => 'Текст',
      'number' => 'Число',
      'select' => 'Список'
    ];
}
