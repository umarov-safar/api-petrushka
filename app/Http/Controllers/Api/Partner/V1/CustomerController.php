<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Customers\CustomerQuery;
use App\JsonApi\Partner\V1\Customers\CustomerRequest;
use App\JsonApi\Partner\V1\Customers\CustomerSchema;
use App\Models\Company;
use App\Services\CompanyService;
use App\JsonApi\Proxies\CompanyPartner; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class CustomerController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
   /* use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;*/

}
