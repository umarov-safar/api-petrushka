<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'partner_user';

    protected $fillable = ['user_id', 'partner_id', 'setting_info', 'phone', 'status', 'is_admin'];

    protected $casts = [
        'setting_info' => 'array'
    ];

    const IS_ADMIN_YES = 1; //
    const IS_ADMIN_NO = 0; //

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
