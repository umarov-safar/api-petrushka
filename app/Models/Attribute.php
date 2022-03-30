<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    // Types of attributes
    const TYPES_OF_ATTRIBUTES = [
      'text' => 'Текст',
      'number' => 'Число',
      'select' => 'Список'
    ];



}
