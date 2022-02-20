<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_user';

    protected $fillable = ['user_id', 'company_id', 'setting_info', 'phone', 'status'];

    protected $casts = [
        'setting_info' => 'array'
    ];


    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
