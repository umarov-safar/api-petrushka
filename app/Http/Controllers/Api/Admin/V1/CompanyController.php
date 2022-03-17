<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\CompanyDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Companies\CompanyQuery;
use App\JsonApi\Admin\V1\Companies\CompanyRequest;
use App\JsonApi\Admin\V1\Companies\CompanySchema;
use App\JsonApi\Admin\V1\CompanyUsers\CompanyUserCollectionQuery;
use App\Models\Company;
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
            $attributes['phone']
        );

        $company = $this->companyService->create($dto);

        if(!$company) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
            }
        // return false;

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
            //$attributes['phone']
            $company->phone, //$attributes['phone'],  Запрещено менять номер телефона
        );

        $company = $this->companyService->update($dto, $company->id);

        if(!$company){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company = Company::find($company->getKey());
        return new DataResponse($company);
    }

    /**
     * Удаление существующего ресурса. Замена на блокировку компании.
     *
     * @param CompanyRequest $request
     * @param Company $user
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(CompanyRequest $request, Company $company)
    {
        //var_dump($user->roles());
        //exit;
        $dto = new CompanyDto(
            $company->inn,
            $company->info,
            Company::BLOCK_YES,
            $company->phone,
        );

        $company = $this->companyService->update($dto, $company->id);

        if(!$company){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company = Company::find($company->getKey());
        return new DataResponse($company);
    }


    // для чего этот метод?
    public function updateCompanyUsers(CompanySchema $schema, CompanyRequest $request, CompanyUserCollectionQuery $query, Company $company)
    {
        \Log::info($request->all());
    }

}
