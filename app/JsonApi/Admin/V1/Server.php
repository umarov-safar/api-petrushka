<?php

namespace App\JsonApi\Admin\V1;

use App\JsonApi\Admin\V1\Abilities\AbilitySchema;
use App\JsonApi\Admin\V1\Partners\PartnerSchema;
use App\JsonApi\Admin\V1\Users\UserSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/admin/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            Roles\RoleSchema::class,
            AbilitySchema::class,
            UserSchema::class,
            PartnerSchema::class,
            PartnerUsers\PartnerUserSchema::class,
            Companies\CompanySchema::class,
            CompanyUsers\CompanyUserSchema::class,
            Account\AccountSchema::class,
            Attributes\AttributeSchema::class,
            AttributeValues\AttributeValueSchema::class
        ];
    }
}
