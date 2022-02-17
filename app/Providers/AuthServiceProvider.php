<?php

namespace App\Providers;

use App\Models\Admin\Partner;
use App\Models\Admin\Role;
use App\Models\User;
use App\Policies\Admin\AbilityPolicy;
use App\Policies\Admin\PartnerPolicy;
use App\Policies\Admin\RolePolicy;
use App\Policies\UserPolicy;
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
        User::class => UserPolicy::class,
        Ability::class => AbilityPolicy::class,
        Role::class => RolePolicy::class,
        Partner::class => PartnerPolicy::class,
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
