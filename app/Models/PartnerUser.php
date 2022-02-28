<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'partner_user';

    protected $fillable = ['user_id', 'partner_id', 'setting_info', 'phone', 'status'];

    protected $casts = [
        'setting_info' => 'array'
    ];


}
