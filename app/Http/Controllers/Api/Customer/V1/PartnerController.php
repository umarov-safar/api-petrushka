<?php

namespace App\Http\Controllers\Api\Customer\V1;

use App\Dtos\CompanyDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Customer\V1\Partners\PartnerQuery;
use App\JsonApi\Customer\V1\Partners\PartnerRequest;
use App\JsonApi\Customer\V1\Partners\PartnerSchema;
use App\Models\Partner;
use App\Services\PartnerService;
use App\JsonApi\Proxies\PartnerCustomer; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class PartnerController extends Controller
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


    /**
     * Company service for creating and updating company
     * @var PartnerService
     */
    protected PartnerService $partnerService;


    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }
}
