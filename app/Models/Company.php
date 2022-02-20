<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['inn', 'info', 'is_block', 'is_admin_user'];

    protected $casts = [
        'info' => 'array',
    ];


    public function companyUsers()
    {
        return $this->belongsToMany(User::class, 'company_user')->withPivot('phone', 'setting_info', 'status');
    }


}
