<?php

namespace App\Providers;

use App\Models\Role;
use App\Policies\AbilityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Silber\Bouncer\Database\Ability;

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
        \App\JsonApi\Proxies\CompanyPartner::class => \App\Policies\Partner\CompanyPolicy::class,
        \App\JsonApi\Proxies\PartnerUserPartner::class => \App\Policies\Partner\PartnerUserPolicy::class,
        \App\JsonApi\Proxies\MyCompany::class => \App\Policies\Partner\MyCompanyPolicy::class,
        \App\JsonApi\Proxies\Account::class => \App\Policies\AccountPolicy::class,
        \App\Models\Attribute::class => \App\Policies\AttributePolicy::class

        \App\JsonApi\Proxies\CustomerPartner::class => \App\Policies\Partner\CustomerPolicy::class,
        \App\JsonApi\Proxies\MyCompanyCustomer::class => \App\Policies\Customer\MyCompanyPolicy::class,
        \App\JsonApi\Proxies\CompanyUserCustomer::class => \App\Policies\Customer\CompanyUserPolicy::class,
        \App\JsonApi\Proxies\PartnerCustomer::class => \App\Policies\Customer\PartnerPolicy::class,
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
