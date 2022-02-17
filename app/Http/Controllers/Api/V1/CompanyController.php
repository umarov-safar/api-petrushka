<?php

namespace App\Http\Controllers\Api\V1;

use App\Dtos\CompanyDto;
use App\Http\Controllers\Controller;
use App\JsonApi\V1\Companies\CompanyQuery;
use App\JsonApi\V1\Companies\CompanyRequest;
use App\JsonApi\V1\Companies\CompanySchema;
use App\Models\Company;
use App\Services\CompanyService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class CompanyController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;


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
     * Create company with JSON:API
     * @param CompanySchema $schema
     * @param CompanyRequest $request
     * @param CompanyQuery $query
     */
    public function store(CompanySchema $schema, CompanyRequest $request, CompanyQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyDto(
          $attributes['inn'],
          $attributes['info'] ?? null,
          $attributes['isBlock'] ?? 0,
          $attributes['adminUserId']
        );

        $company = $this->companyService->create($dto);

        if(!$company) return false;

        $company = Company::find($company->getKey());
        return new DataResponse($company);
    }


    public function update(CompanySchema $schema, CompanyRequest $request, CompanyQuery $query, Company $company)
    {

        $attributes = $request->data['attributes'];

        $dto = new CompanyDto(
            $attributes['inn'],
            $attributes['info'] ?? null,
            $attributes['isBlock'] ?? 0,
            $attributes['adminUserId']
        );

        $company = $this->companyService->update($dto, $company->id);

        if(!$company) return false;

        $company = Company::find($company->getKey());
        return new DataResponse($company);
    }
}
