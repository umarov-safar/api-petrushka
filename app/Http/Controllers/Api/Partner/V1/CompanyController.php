<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\CompanyDto;
use App\Http\Controllers\Controller;
/*use App\JsonApi\Admin\V1\Companies\CompanyQuery;
use App\JsonApi\Admin\V1\Companies\CompanyRequest;
use App\JsonApi\Admin\V1\Companies\CompanySchema;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserCollectionQuery;*/
use App\Models\Partner\Company;
use App\Services\CompanyService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class CompanyController extends Controller
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
     * @var CompanyService
     */
    protected CompanyService $companyService;


    public function __construct()
    {
        $this->companyService = new CompanyService();
    }
}
