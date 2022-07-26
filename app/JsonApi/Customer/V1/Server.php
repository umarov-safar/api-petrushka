<?php

namespace App\JsonApi\Customer\V1;

use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/customer/v1';

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
            // @TODO
            Employees\EmployeeSchema::class,
            MyCompanies\MyCompanySchema::class,
            Account\AccountSchema::class,
            Partners\PartnerSchema::class,
            Categories\CategorySchema::class,
            Products\ProductSchema::class,
        ];
    }
}
