<?php

namespace App\JsonApi\Proxies;

use App\Models\PartnerUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;
//use App\User as User;
use Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Database\Eloquent\Builder;

class PartnerUserPartner extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyPartner constructor.
     *
     * @param PartnerUser|null $partnerUser
     */
    public function __construct(PartnerUser $partnerUser = null)
    {
        \Log::debug('_construct');
        parent::__construct($partnerUser ?: new PartnerUser());
    }

    protected static function boot1()
    {
        \Log::debug('boot');
        parent::boot();

        // never let a company user see the users of other companies
        $user = Auth::user();
        \Log::debug('$user');
        if (Auth::check() && Bouncer::is($user)->a('partner')) {
            \Log::debug($user->partner->id);
            if($partnerId = $user->partner->id){
                static::addGlobalScope('partner_id', function (Builder $builder) use ($partnerId) {
                    $builder->where('partner_id', $partnerId);
                });
            }
        }
    }

}
