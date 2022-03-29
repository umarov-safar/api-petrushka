<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\CompanyDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Companies\CompanyQuery;
use App\JsonApi\Partner\V1\Companies\CompanyRequest;
use App\JsonApi\Partner\V1\Companies\CompanySchema;
use App\Models\Company;
use App\Services\CompanyService;
use App\JsonApi\Proxies\CompanyPartner; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class CompanyController extends Controller
{

    use Actions\FetchMany;
//    use Actions\FetchOne;
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

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param CompanySchema $schema
     * @param CompanyQuery $request
     * @param CompanyPartner $partner
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(CompanySchema $schema, CompanyQuery $request, CompanyPartner $partner)
    {
        //dd($partner);

        $model = $schema
            ->repository()
            ->queryOne($partner)
            ->withRequest($request)
            ->first();


        // do something custom...

        return new DataResponse($model);
    }
}
