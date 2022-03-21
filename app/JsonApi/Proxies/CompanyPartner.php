<?php

namespace App\JsonApi\Proxies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelJsonApi\Eloquent\Proxy;

class CompanyPartner extends Proxy
{
    use HasFactory, SoftDeletes;

    /**
     * CompanyPartner constructor.
     *
     * @param Company|null $company
     */
    public function __construct(Company $company = null)
    {
        parent::__construct($company ?: new Company());
    }

    protected static function boot()
    {
        parent::boot();

        // never let a company user see the users of other companies
        /*
        if (Auth::check() && Auth::user()->hasRole('client')) {
            $clientId = Auth::user()->client->id;

            static::addGlobalScope('client_id', function (Builder $builder) use ($clientId) {
                $builder->where('client_id', $clientId);
            });
        }*/
    }

}
