<?php

namespace App\Providers;

use App\Models\Role;
use App\Policies\AbilityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Silber\Bouncer\Database\Ability;
//use App\Policies\Partner\CompanyPolicy as partnerCompanyPolicy;
//use App\JsonApi\Proxies\CompanyPartner as partnerCompany;
// use App\Models\Partner\Company as partnerCompany;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Ability::class => AbilityPolicy::class,
        //partnerCompany::class => partnerCompanyPolicy::class,
        \App\JsonApi\Proxies\CompanyPartner::class => \App\Policies\Partner\CompanyPolicy::class,
        \App\JsonApi\Proxies\PartnerUserPartner::class => \App\Policies\Partner\PartnerUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
