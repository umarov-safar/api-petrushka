<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone', 'info', 'is_block', 'admin_user_id'];

    protected $casts = [
        'info' => 'array'
    ];

    const BLOCK_YES = 1; // Заблокирован
    const BLOCK_NO = 0; // Не заблокирован

    public function partnerUsers()
    {
        return $this->belongsToMany(User::class, 'partner_user')->withPivot('phone', 'setting_info', 'status');
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }
}
